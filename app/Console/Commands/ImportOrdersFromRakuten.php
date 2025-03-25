<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use DateTimeZone;
use Wareon\RakutenRms\Facades\RakutenRms;
use App\Models\ShoppingMallOrders;
use App\Consts\ShoppingMallOrders as ShoppingMallOrdersConst;

class ImportOrdersFromRakuten extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-rakuten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import order data from Rakuten';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // config or .env等に移行
        $configs = [
            'setsubi' => [
                'service_secret' => 'SP273013_H8TrLeTsJ5dpLWAt',
                'license_key' => 'SL273013_BfDbA5Q7UDMszgHE',
            ],
            'e-setsubi' => [
                'service_secret' => 'SP320228_A9GX2EZlvdtbqCpk',
                'license_key' => 'SL320228_EkA85wGQTZxmcZvB',
            ],
            'tokyo-aircon' => [
                'service_secret' => 'SP316657_yr7kSfdbqKjAB7ak',
                'license_key' => 'SL316657_cikTZKTMTguuJ7Uu',
            ],
        ];

        foreach ($configs as $mall => $config) {
            RakutenRms::changeConfig($config);
            if ($mall === 'setsubi') {
                $shop_name = 's';
            } elseif ($mall === 'e-setsubi') {
                $shop_name = 'e';
            } elseif ($mall === 'tokyo-aircon') {
                $shop_name = 'k';
            }
            $startDate = new DateTime('now');
            $startDate->setTimeZone(new DateTimeZone('Asia/Tokyo'));
            $endDate = new DateTime('now');
            $endDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));
        
            //ページングリクエスト情報
            $paginationRequestModel = [
                'requestRecordsAmount' => '100', //１回のリクエストで取得する件数
                'requestPage' => '1' //リクエストページ番号
            ];

            //リクエスト内容
            $params = [
                'dateType' => '1',    //期間検索種別 1:注文日
                'startDatetime' => $startDate->modify('-7 days')->format('Y-m-d\TH:i:sO'), //期間検索開始日時(YYYY-MM-DDThh:mm:ss+09:00)
                'endDatetime' => $endDate->format('Y-m-d\TH:i:sO'),   //期間検索終了日時(YYYY-MM-DDThh:mm:ss+09:00)
                'PaginationRequestModel' => $paginationRequestModel   //ページングリクエスト情報
            ];
            $result = RakutenRms::searchOrder($params);
            if ($result['MessageModelList'][0]['messageType'] === 'INFO' &&
                $result['MessageModelList'][0]['messageCode'] === 'ORDER_EXT_API_SEARCH_ORDER_INFO_101') {
            
                $params = [
                    'orderNumberList' => $result['orderNumberList'], //注文番号リスト(searchOrderで取得したもの)
                    'version' => '7' // SKU対応
                ];
            
                $result = RakutenRms::getOrder($params);

                if ($result['MessageModelList'][0]['messageType'] === 'INFO' &&
                    $result['MessageModelList'][0]['messageCode'] === 'ORDER_EXT_API_GET_ORDER_INFO_101') {
                    $data = [];

                    foreach ($result['OrderModelList'] as $order) {

                        foreach ($order['PackageModelList'] as $package) {

                            foreach ($package['ItemModelList'] as $item) {
                                $opt1 = $item['selectedChoice'];
                                if (isset($item['SkuModelList'][0]['skuInfo'])) {
                                    $opt1 = $item['SkuModelList'][0]['skuInfo'] . "\n" . $item['selectedChoice'];
                                }
                            
                                $opt2 = '判別不能';
                                if (strpos($item['itemName'], 'ワイヤード') !== false) {
                                    $opt2 = 'ワイヤード';
                                } elseif (strpos($item['itemName'], 'ワイヤレス') !== false) {
                                    $opt2 = 'ワイヤレス';
                                }

                                if ($package['SenderModel']['prefecture'] === '') {
                                    $package['SenderModel']['prefecture'] = $order['OrdererModel']['prefecture'];
                                }

                                if ($package['SenderModel']['city'] === '') {
                                    $package['SenderModel']['city'] = $order['OrdererModel']['city'];
                                }

                                // 指定された日付文字列を解析
                                $dateTime = DateTime::createFromFormat(DateTime::ISO8601, $order['orderDatetime']);

                                // タイムゾーンをAsia/Tokyoに変更
                                $dateTime->setTimezone(new DateTimeZone('Asia/Tokyo'));

                                // MySQLのdatetime型に合わせたフォーマットで文字列を生成
                                $formattedDateString = $dateTime->format('Y-m-d H:i:s');
                            
                                $address = $order['OrdererModel']['prefecture'] . $order['OrdererModel']['city'] . str_replace(['(', ')'], ['[', ']'], mb_convert_kana($order['OrdererModel']['subAddress'], 'aKVs', 'UTF-8'));
                                $addressKana = exec('echo '. $address .' | mecab -Oyomi ', $output);
                                $senderAddress = $package['SenderModel']['prefecture'] . $package['SenderModel']['city'] . str_replace(['(', ')'], ['[', ']'], mb_convert_kana($package['SenderModel']['subAddress'], 'aKVs', 'UTF-8'));
                                $senderAddressKana = exec('echo '. $senderAddress .' | mecab -Oyomi ', $output);
                                $data[] = [
                                    'id' => $order['orderNumber'] . '-' . $item['itemNumber'],
                                    'mall_id' => $mall,
                                    'order_id' => $order['orderNumber'],
                                    'ukey' => $order['orderNumber'] . '-' . $item['itemNumber'],
                                    'shop_mall_id' => sprintf(ShoppingMallOrdersConst::FORMAT_SHOP_MALL_ID_RAKUTEN, $shop_name, $mall),
                                    'shop_name' => $shop_name,
                                    'mall_name' => '楽天',
                                    'name' => $order['OrdererModel']['familyName'] . ' ' . $order['OrdererModel']['firstName'],
                                    'name_kana' => $order['OrdererModel']['familyNameKana'] . ' ' . $order['OrdererModel']['firstNameKana'],
                                    'zip' => $order['OrdererModel']['zipCode1'] . $order['OrdererModel']['zipCode2'],
                                    'prefecture' => $order['OrdererModel']['prefecture'],
                                    'city' => $order['OrdererModel']['city'],
                                    'sub_address' => mb_convert_kana($order['OrdererModel']['subAddress'], 'aKVs', 'UTF-8'),
                                    'address' => $address,
                                    'address_kana' => $addressKana,
                                    'progress' => $order['orderProgress'],
                                    'tel' => $order['OrdererModel']['phoneNumber1'] . $order['OrdererModel']['phoneNumber2'] . $order['OrdererModel']['phoneNumber3'],
                                    'email' => $order['OrdererModel']['emailAddress'],
                                    'option1' => $opt1,
                                    'option2' => $opt2,
                                    'sender_name' => $package['SenderModel']['familyName'] . ' ' . $package['SenderModel']['firstName'],
                                    'sender_name_kana' => $package['SenderModel']['familyNameKana'] . ' ' . $package['SenderModel']['firstNameKana'],
                                    'sender_zip' => $package['SenderModel']['zipCode1'] . $package['SenderModel']['zipCode2'],
                                    'sender_prefecture' => $package['SenderModel']['prefecture'],
                                    'sender_city' => $package['SenderModel']['city'],
                                    'sender_sub_address' => mb_convert_kana($package['SenderModel']['subAddress'], 'aKVs', 'UTF-8'),
                                    'sender_address' => $senderAddress,
                                    'sender_address_kana' => $senderAddressKana,
                                    'sender_tel' => $package['SenderModel']['phoneNumber1'] . $package['SenderModel']['phoneNumber2'] . $package['SenderModel']['phoneNumber3'],
                                    'item_name' => $item['itemName'],
                                    'item_model' => $item['itemNumber'],
                                    'item_price' => $item['price'],
                                    'item_unit' => $item['units'],
                                    'payment_code' => $order['SettlementModel']['settlementMethodCode'],
                                    'payment_method' => $order['SettlementModel']['settlementMethod'],
                                    'is_stock_confirm' => 0,
                                    'note' => $order['remarks'],
                                    'discount_amount' => 0,
                                    'ordered_at' => $formattedDateString,
                                ];
                            }
                        }
                    }
                    ShoppingMallOrders::upsert(
                        $data,
                        ['id'],
                        [
                            'name', 'prefecture', 'city', 'item_unit', 'option1', 'option2',
                            'progress', 'ordered_at', 'name_kana', 'zip', 'address', 'address_kana', 'tel', 'email',
                            'sender_name', 'sender_name_kana', 'sender_zip', 'sender_prefecture', 'sender_city', 'sender_sub_address',
                            'sender_address', 'sender_address_kana', 'sender_tel',
                            'item_name', 'item_model', 'item_price', 'payment_code', 'payment_method', 'note', 'discount_amount'
                        ]
                    );
                    $this->info('saved 楽天 ' . $mall . ' data successfully');
                }
            }
        }
    }
}
