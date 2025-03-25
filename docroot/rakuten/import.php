<?php
require_once(dirname(__FILE__, 3) . '/cfg/db_config.php');
require_once(dirname(__FILE__, 3) . '/config/config.php');
require_once(dirname(__FILE__, 3) . '/lib/Util.class.php');

$path = basename(realpath("../"));

if ($path == "setsu-bi") {
	$c = "s";
} elseif ($path == "e-setsubi") {
	$c = "e";
} elseif ($path == "tokyo-aircon") {
	$c = "k";
}

try {
	$dbh = new PDO($dsn, $db_user, $db_pass);

	$sql = 'SELECT * FROM `supplier_setting` WHERE `company` = "'.$c.'";';
	$row = $dbh->query($sql);

    foreach ($row as $val) {
        $r_secret = $val['r1_secret'];
        $r_key = $val['r1_key'];
        $r_url = $val['r1_url'];
    }

    $startDate = new DateTime('now');
    $startDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));
    $endDate = new DateTime('now');
    $endDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));
    $authkey = base64_encode($r_secret . ':' . $r_key);

    $header = [
        "Content-Type: application/json; charset=utf-8",
        "Authorization: ESA {$authkey}"
    ];

    //ページングリクエスト情報
    $paginationRequestModel = [
        "requestRecordsAmount" => '100', //１回のリクエストで取得する件数
        "requestPage" => '1' //リクエストページ番号
    ];

    //リクエスト内容
    $params = [
        "dateType" => '1',    //期間検索種別 1:注文日
        "startDatetime" => $startDate->modify('-7 days')->format('Y-m-d\TH:i:sO'), //期間検索開始日時(YYYY-MM-DDThh:mm:ss+09:00)
        "endDatetime" => $endDate->format('Y-m-d\TH:i:sO'),   //期間検索終了日時(YYYY-MM-DDThh:mm:ss+09:00)
        "PaginationRequestModel" => $paginationRequestModel   //ページングリクエスト情報
    ];

    $ch = curl_init('https://api.rms.rakuten.co.jp/es/2.0/order/searchOrder/');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER  => $header,
        CURLOPT_POSTFIELDS => json_encode($params)
    ]);

    //リクエストの送信
    $result = curl_exec($ch);

    if (curl_error($ch)) {
        $response = curl_error($ch);
        return 'エラー：'.$response;
    }

    curl_close($ch);

    if ($result) {
        $result = json_decode($result);

        //注文番号リスト
        //print_r($result->orderNumberList);

        $orderNumberList = $result->orderNumberList;

        //ベース情報
        $params = [
            'orderNumberList' => $orderNumberList, //注文番号リスト(searchOrderで取得したもの)
            'version' => '7' // SKU対応
            //'version' => '5' // 領収書、前払い期限版
        ];

        $ch = curl_init('https://api.rms.rakuten.co.jp/es/2.0/order/getOrder/');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => json_encode($params)
        ]);

        //リクエストの送信
        $result = curl_exec($ch);

        if (curl_error($ch)) {
            return 'エラー';
        }

        curl_close($ch);

        $result= json_decode($result);

        //メッセージモデルリスト
        $MessageModelList = $result->MessageModelList[0];

        if ($MessageModelList->messageCode != 'ORDER_EXT_API_GET_ORDER_INFO_101') {
            //受注一覧の取得失敗
            return '受注情報の取得失敗';
        }

        //受注モデルリスト
        $OrderModelList = $result->OrderModelList;
        // print_r($OrderModelList);

        foreach ($OrderModelList as $order) {
            $orderNumber = $order->orderNumber;
            $orderProgress = $order->orderProgress;
            $orderDatetime = $order->orderDatetime;

            $sei = $order->OrdererModel->familyName;
            $mei = $order->OrdererModel->firstName;
            $name = $sei." ".$mei;

            $seiKana = $order->OrdererModel->familyNameKana;
            $meiKana = $order->OrdererModel->firstNameKana;
            $nameKana = $seiKana." ".$meiKana;

            $zipCode1 = $order->OrdererModel->zipCode1;
            $zipCode2 = $order->OrdererModel->zipCode2;
            $zip = $zipCode1.$zipCode2;

            $prefecture = $order->OrdererModel->prefecture;
            $city = $order->OrdererModel->city;
            $subAddress = $order->OrdererModel->subAddress;
            $address = $prefecture.$city.$subAddress;

            $addressKana = "";

            $phoneNumber1 = $order->OrdererModel->phoneNumber1;
            $phoneNumber2 = $order->OrdererModel->phoneNumber2;
            $phoneNumber3 = $order->OrdererModel->phoneNumber3;
            $phoneNumber = $phoneNumber1.$phoneNumber2.$phoneNumber3;

            $emailAddress = $order->OrdererModel->emailAddress;

            $settlementMethodCode = $order->SettlementModel->settlementMethodCode;

            $settlementMethod = $order->SettlementModel->settlementMethod;

            $remarks = $order->remarks;

            $TotalCouponDiscount = 0;
            $TotalCouponDiscount = $order->couponAllTotalPrice;

            $PackageModelList = $order->PackageModelList;

            $PointModel = $order->PointModel;

            $TotalCouponDiscount += $PointModel->usedPoint;

            // print_r($PackageModelList);

            foreach($PackageModelList as $package){
                $sendersei = $package->SenderModel->familyName;
                $sendermei = $package->SenderModel->firstName;
                $senderName = $sendersei." ".$sendermei;

                $senderseikana = $package->SenderModel->familyNameKana;
                $sendermeikana = $package->SenderModel->firstNameKana;
                $senderNameKana = $senderseikana." ".$sendermeikana;

                $senderzipCode1 = $package->SenderModel->zipCode1;
                $senderzipCode2 = $package->SenderModel->zipCode2;
                $senderZip = $senderzipCode1.$senderzipCode2;

                $senderprefecture = $package->SenderModel->prefecture;
                $sendercity = $package->SenderModel->city;
                $sendersubAddress = $package->SenderModel->subAddress;
                $senderAddress = $senderprefecture.$sendercity.$sendersubAddress;

                // $senderAddressKana = YomiGana($senderAddress);
                $senderAddressKana = "";

                $senderphoneNumber1 = $package->SenderModel->phoneNumber1;
                $senderphoneNumber2 = $package->SenderModel->phoneNumber2;
                $senderphoneNumber3 = $package->SenderModel->phoneNumber3;
                $senderPhoneNumber = $senderphoneNumber1.$senderphoneNumber2.$senderphoneNumber3;


                $ItemModelList = $package->ItemModelList;

                // print_r($ItemModelList);

                $i = 0;
                foreach ($ItemModelList as $item) {
                    $itemNumber = $item->itemNumber;
                    $itemName = $item->itemName;
                    $price = $item->price;
                    $units = $item->units;
                    $opt1 = $item->selectedChoice;
                    if (isset($item->skuModelList[0]->skuInfo)) {
                        $opt1 = $item->skuModelList[0]->skuInfo . "\n" . $item->selectedChoice;
                    }
                    // $opt1 = str_replace("パネルカラーをお選びください:", "", $opt);
                    // preg_match('/パネルをお選び下さい:(.*+)/', $opt, $m);
                    // $opt1 = $m[1];

                    if (strpos($itemName, "ワイヤード") !== false) {
                        $opt2 = "ワイヤード";
                    } elseif (strpos($itemName, "ワイヤレス") !== false) {
                        $opt2 = "ワイヤレス";
                    } else {
                        $opt2 = "判別不能";
                    }

                    $ukey = $orderNumber.'-'.$itemNumber;

                    // echo $ukey;
                    if ($senderprefecture == "") {
                        $senderprefecture = $prefecture;
                    }
                    if ($sendercity == "") {
                        $sendercity = $city;
                    }
                    $sql = "INSERT INTO `cart_raw_data` (";
                    $sql .= "`ukey`, `company`, `mall`, `url`, `order_id`, `name`, `pref`, `city`, `model`, `unit`, `opt1`, `opt2`, `orderdate`, `created`";
                    $sql .= ") VALUES (";
                    $sql .= ":ukey, :company, '楽天', :r_url, :orderNumber, :name, :senderprefecture, :sendercity, :itemNumber, :units, :opt1, :opt2, :orderDatetime, NOW()";
                    $sql .= ") ON DUPLICATE KEY UPDATE ";
                    $sql .= "`name` = :name, `pref` = :senderprefecture, `city` = :sendercity, `unit` = :units, `opt1` = :opt1, `opt2` = :opt2";

                    $params = [
                        ":ukey" => $ukey,
                        ":company" => $c,
                        ":r_url" => $r_url,
                        ":orderNumber" => $orderNumber,
                        ":name" => $name,
                        ":senderprefecture" => $senderprefecture,
                        ":sendercity" => $sendercity,
                        ":itemNumber" => $itemNumber,
                        ":units" => $units,
                        ":opt1" => $opt1,
                        ":opt2" => $opt2,
                        ":orderDatetime" => $orderDatetime,
                    ];

                    //echo $sql."<br/>";
                    Util::log($sql);

                    /*
                      $insert_pat = "/-|^mitsumori(.*)|お時間指定料|車種ご指定料（ゲート車）|部材|木台/";
                      if(!preg_match($insert_pat, $model)){
                      $dbh->query($getsql);
                      }
                    */
                    $dbh->query($sql);


                    if ($i != 0) {
                        $TotalCouponDiscount = 0;
                    }

                    $sql = "INSERT INTO `cart_raw_search` (";
                    $sql .= "`ukey`, `company`, `mall`, `url`, `orderNumber`, `orderProgress`, `orderDatetime`, `name`, `nameKana`, `zip`, `address`, `addressKana`, `phoneNumber`, ";
                    $sql .= "`emailAddress`, `senderName`, `senderNameKana`, `senderZip`, `senderAddress`, `senderAddressKana`, `senderPhoneNumber`, `itemName`, `itemNumber`, `price`, ";
                    $sql .= "`units`, `settlementMethodCode`, `settlementMethod`, `remarks`, `updated`, `discount`, `flag`";
                    $sql .= ") VALUES (";
                    $sql .= ":ukey, :company, '楽天', :r_url, :orderNumber, :orderProgress, :orderDatetime, :name, :nameKana, :zip, :address, :addressKana, :phoneNumber, :emailAddress, ";
                    $sql .= ":senderName, :senderNameKana, :senderZip, :senderAddress, :senderAddressKana, :senderPhoneNumber, :itemName, :itemNumber, :price, :units, ";
                    $sql .= ":settlementMethodCode, :settlementMethod, :remarks, NOW(), :TotalCouponDiscount, 0";
                    $sql .= ") ON DUPLICATE KEY UPDATE ";
                    $sql .= "`orderProgress` = :orderProgress, `orderDatetime` = :orderDatetime, `name` = :name, `nameKana` = :nameKana, `zip` = :zip, `address` = :address, ";
                    $sql .= "`addressKana` = :addressKana, `phoneNumber` = :phoneNumber, `emailAddress` = :emailAddress, `senderName` = :senderName, `senderNameKana` = :senderNameKana, ";
                    $sql .= "`senderZip` = :senderZip, `senderAddress` = :senderAddress, `senderAddressKana` = :senderAddressKana, `senderPhoneNumber` = :senderPhoneNumber, ";
                    $sql .= "`itemName` = :itemName, `itemNumber` = :itemNumber, `price` = :price, `units` = :units, `settlementMethodCode` = :settlementMethodCode, ";
                    $sql .= "`settlementMethod` = :settlementMethod, `remarks` = :remarks, `discount` = :TotalCouponDiscount";

                    $params = [
                        ":ukey" => $ukey,
                        ":company" => $c,
                        ":r_url" => $r_url,
                        ":orderNumber" => $orderNumber,
                        ":orderProgress" => $orderProgress,
                        ":orderDatetime" => $orderDatetime,
                        ":name" => $name,
                        ":nameKana" => $nameKana,
                        ":zip" => $zip,
                        ":address" => $address,
                        ":addressKana" => $addressKana,
                        ":phoneNumber" => $phoneNumber,
                        ":emailAddress" => $emailAddress,
                        ":senderName" => $senderName,
                        ":senderNameKana" => $senderNameKana,
                        ":senderZip" => $senderZip,
                        ":senderAddress" => $senderAddress,
                        ":senderAddressKana" => $senderAddressKana,
                        ":senderPhoneNumber" => $senderPhoneNumber,
                        ":itemName" => $itemName,
                        ":itemNumber" => $itemNumber,
                        ":price" => $price,
                        ":units" => $units,
                        ":settlementMethodCode" => $settlementMethodCode,
                        ":settlementMethod" => $settlementMethod,
                        ":remarks" => $remarks,
                        ":TotalCouponDiscount" => $TotalCouponDiscount,
                    ];

                    echo $sql."<br/>";
                    Util::log($sql);
                    $dbh->query($sql);
                    $i++;
                }
            }
        }
    }
} catch (PDOException $e) {
	print('Error:'.$e->getMessage());
	die();
}


?>
