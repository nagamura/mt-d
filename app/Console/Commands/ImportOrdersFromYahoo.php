<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use DateTimeZone;
use App\Models\ShoppingMallOrders;
use Schema;
use YConnect\Constant\GrantType;
use YConnect\Constant\OIDConnectDisplay;
use YConnect\Constant\OIDConnectPrompt;
use YConnect\Credential\BearerToken;
use YConnect\Credential\ClientCredential;
use YConnect\Credential\RefreshToken;
use YConnect\Endpoint\AuthorizationClient;
use YConnect\Endpoint\AuthorizationCodeClient;
use YConnect\Endpoint\PublicKeysClient;
use YConnect\Endpoint\RefreshTokenClient;
use YConnect\Exception\TokenException;
use YConnect\YConnectClient;
use App\Consts\MallYahoo;

class ImportOrdersFromYahoo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-yahoo';

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
        $appId = 'dj00aiZpPU5uNXZJaFJsSUQ5cyZzPWNvbnN1bWVyc2VjcmV0Jng9YWI-';
        $appSecret = 'PYwvmPs15drtvqRqRKzwPkyPVSyzbkXPaC8kLXhe';
        $appName = 'tokyo-aircon';
        $certVer = 2;

        $json = file_get_contents(resource_path('data/yahoo/' . $appName) . '/token1.json');
        $data = json_decode($json, true);

        // ヘッダ設定
        $key = file_get_contents(resource_path('data/yahoo/' . $appName) . '/public.key');
        $authValue = $appName . ":" . time();
        $publicKey = openssl_pkey_get_public($key);
        openssl_public_encrypt($authValue, $encryptedAuthValue, $publicKey);
        $encAuthValue = base64_encode($encryptedAuthValue);
        $appSecretEncoded = base64_encode($appId . ':' . $appSecret);
        $header = [
            'POST /yconnect/v2/token HTTP/1.1',
            'Host: auth.login.yahoo.co.jp',
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Authorization: Basic ' . $appSecretEncoded,
            'X-sws-signature:' . $encAuthValue,
            'X-sws-signature-version:' . $certVer
        ];

        $param = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $data['refresh_token']
        ];

        $ch = curl_init(MallYahoo::API_TOKEN);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST,           true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($param));
        $response = curl_exec($ch);
        $result = json_decode($response, true);
        if (isset($result['error'])) {
            // $options = [
            //     $path => TOKEN_URL,
            // ];
            // Util::mail($result, $options);
        }
        curl_close($ch);

        // refresh_token更新
        $token = json_decode($response, true);
        $response = array_merge($token, ['refresh_token' => $data['refresh_token']]);
        $response = json_encode($response);
        file_put_contents(resource_path('data/yahoo/' . $appName) . '/token1.json', $response);
        $header = [
            'POST /ShoppingWebService/V1/orderList HTTP/1.1',
            'Host: circus.shopping.yahooapis.jp',
            'Authorization: Bearer ' . $data['access_token'],
            'X-sws-signature:' . $encAuthValue,
            'X-sws-signature-version:' . $certVer,
        ];

        $startDate = new DateTime('now');
        $startDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));
        $endDate = new DateTime('now');
        $endDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));

        $startDatetime = $startDate->modify('-7 days')->format('YmdHis'); //期間検索開始日時(YYYY-MM-DDThh:mm:ss+09:00)
        $endDatetime = $endDate->format('YmdHis');   //期間検索終了日時(YYYY-MM-DDThh:mm:ss+09:00)
        $param = sprintf(MallYahoo::PARAM_ORDER_LIST, $startDatetime, $endDatetime, $appName);

        $ch = curl_init(MallYahoo::API_ORDER_LIST);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST,           true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $param);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = simplexml_load_string($response);
        if (!isset($response->Status) || ($response->Status != 'OK')) {
            $options = [
                $path => $url,
            ];
            //Util::mail($response, $options);
        }

        //受注リスト
        $orderList = $response->Search->OrderInfo;
        $data = [];        
        foreach ($orderList as $order) {
            $orderNumber = $order->OrderId;
            $orderDatetime =  $order->OrderTime;

            $header = [
                'POST /ShoppingWebService/V1/orderInfo HTTP/1.1',
                'Host: circus.shopping.yahooapis.jp',
                'Authorization: Bearer ' . $data['access_token'],
                'X-sws-signature:' . $encAuthValue,
                'X-sws-signature-version:' . $certVer,
            ];

            $param = sprintf(MallYahoo::PARAM_ORDER_INFO, $order->OrderId, $appName);

            $ch = curl_init(MallYahoo::API_ORDER_INFO);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POST,           true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $params);
            $responses = curl_exec($ch);
            curl_close($ch);

            $responses = str_replace('<![CDATA[', '', $responses);
            $responses = str_replace(']]>', '', $responses);

            // タグ内の内容を取得する正規表現
            //<BuyerComments>タグ内の"<>"を"()"に置換
            $responses = preg_replace_callback(MallYahoo::REGEX_BUYER_COMMENTS, function ($matches) {
                $tagContent = $matches[1];
                $tagContent = str_replace('<', '(', $tagContent);
                $tagContent = str_replace('>', ')', $tagContent);
                return sprintf(MallYahoo::TAG_BUYER_COMMENTS, $tagContent);
            }, $responses);

            $responses = str_replace('&','&amp;',$responses);
            $res = simplexml_load_string($responses);
	
            if (!isset($res->Result->Status) || ($res->Result->Status != 'OK')) {
                // $options = [
                //     $path => $urls,
                // ];
                // Util::mail($res, $options);
            }

            foreach ($res->Result->OrderInfo->Item as $item) {
                
                $opt2 = '判別不能';
                if (strpos($item->Title, 'ワイヤード') !== false) {
                    $opt2 = 'ワイヤード';
                } elseif (strpos($item->Title, 'ワイヤレス') !== false) {
                    $opt2 = 'ワイヤレス';
                }

                if ($res->Result->OrderInfo->Ship->ShipPrefecture === '') {
                    $res->Result->OrderInfo->Ship->ShipPrefecture = $res->Result->OrderInfo->Pay->BillPrefecture;
                }

                if ($res->Result->OrderInfo->Ship->ShipCity === '') {
                    $res->Result->OrderInfo->Ship->ShipCity = $res->Result->OrderInfo->Pay->BillCity;
                }

                $address = $res->Result->OrderInfo->Pay->BillPrefecture . $res->Result->OrderInfo->Pay->BillCity . str_replace(['(', ')'], ['[', ']'], mb_convert_kana($res->Result->OrderInfo->Pay->BillAddress1 . ' ' . $res->Result->OrderInfo->Pay->BillAddress2, 'aKVs', 'UTF-8'));
                $addressKana = exec('echo '. $address .' | mecab -Oyomi ', $output);
                $senderAddress = $res->Result->OrderInfo->Ship->ShipPrefecture . $res->Result->OrderInfo->Ship->ShipCity . str_replace(['(', ')'], ['[', ']'], mb_convert_kana($res->Result->OrderInfo->Ship->ShipAddress1 . ' ' . $res->Result->OrderInfo->Ship->ShipAddress2, 'aKVs', 'UTF-8'));
                $senderAddressKana = exec('echo '. $senderAddress .' | mecab -Oyomi ', $output);
                $data[] = [
                    'id' => $order->OrderId . '-' . $item->ItemId,
                    //'mall_id' => 'tokyo-aircon',
                    'mall_id' => $appName,
                    'order_id' => $order->OrderId,
                    'ukey' => $order->OrderId . '-' . $item->ItemId,
                    //'shop_mall_id' => sprintf(ShoppingMallOrders::FORMAT_SHOP_MALL_ID_YAHOO, $shop_name, $mall_id),
                    'shop_mall_id' => sprintf(ShoppingMallOrders::FORMAT_SHOP_MALL_ID_YAHOO, 'k', $appName),
                    'shop_name' => 'k',
                    'mall_name' => '空調センター',
                    'name' => $res->Result->OrderInfo->Pay->BillLastName . ' ' . $res->Result->OrderInfo->Pay->BillFirstName,
                    'name_kana' => $res->Result->OrderInfo->Pay->BillLastNameKana . ' ' . $res->Result->OrderInfo->Pay->BillFirstNameKana,
                    'zip' => $res->Result->OrderInfo->Pay->BillZipCode,
                    'prefecture' => $res->Result->OrderInfo->Pay->BillPrefecture,
                    'city' => $res->Result->OrderInfo->Pay->BillCity,
                    'sub_address' => $res->Result->OrderInfo->Pay->BillAddress1 . ' ' . $res->Result->OrderInfo->Pay->BillAddress2,
                    'address' => $address,
                    'address_kana' => $addressKana,
                    'progress' => $res->Result->OrderInfo->OrderStatus,
                    'tel' => $res->Result->OrderInfo->Pay->BillPhoneNumber,
                    'email' => $res->Result->OrderInfo->Pay->BillMailAddress,
                    'option1' => $item->ItemOption->Value,
                    'option2' => $opt2,
                    'sender_name' => $res->Result->OrderInfo->Ship->ShipLastName . ' ' . $res->Result->OrderInfo->Ship->ShipFirstName,
                    'sender_name_kana' => $res->Result->OrderInfo->Ship->ShipLastNameKana . ' ' . $res->Result->OrderInfo->Ship->ShipFirstNameKana,
                    'sender_zip' => $res->Result->OrderInfo->Ship->ShipZipCode,
                    'sender_prefecture' => $res->Result->OrderInfo->Ship->ShipPrefecture,
                    'sender_city' => $res->Result->OrderInfo->Ship->ShipCity,
                    'sender_sub_address' => $res->Result->OrderInfo->Ship->ShipAddress1 . ' ' . $res->Result->OrderInfo->Ship->ShipAddress2,
                    'sender_address' => $senderAddress,
                    'sender_address_kana' => $senderAddressKana,
                    'sender_tel' => $res->Result->OrderInfo->Ship->ShipPhoneNumber,
                    'item_name' => $item->Title,
                    'item_model' => $item->ItemId,
                    'item_price' => $item->NonTaxUnitPrice,
                    'item_unit' => $item->Quantity,
                    'payment_code' => $res->Result->OrderInfo->Pay->PayKind,
                    'payment_method' => $res->Result->OrderInfo->Pay->PayMethodName,
                    'is_stock_confirm' => 0,
                    'note' => $res->Result->OrderInfo->BuyerComments,
                    'discount_amount' => 0, //$res->Result->OrderInfo->TotalCouponDiscount,
                    'ordered_at' => $res->Result->OrderInfo->OrderTime,
                ];
                $i++;
                
                //$ukey = $orderNumber.'-'.$itemNumber;
        
                // $cred = new ClientCredential($appId, $appSecret);
                // $client = new YConnectClient($cred);
                // $client->refreshAccessToken($data['refresh_token']);
                // $access_token = $client->getAccessToken();
                // $client->getRefreshToken();
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
    }
}
