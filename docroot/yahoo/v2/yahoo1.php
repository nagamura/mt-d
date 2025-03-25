<?php
require_once(dirname(__FILE__, 3) . '/cfg/db_config.php');
require_once(dirname(__FILE__, 3) . '/config/config.php');
require_once(dirname(__FILE__, 3) . '/lib/Util.class.php');

$path = basename(realpath("../"));
$dir = dirname(__FILE__);
$path = 'tokyo-aircon';

if ($path == "setsu-bi") {
	$c = "s";
} elseif ($path == "e-setsubi") {
	$c = "e";
} elseif ($path == "tokyo-aircon") {
	$c = "k";
}

try{
    $dbh = new PDO($dsn, $db_user, $db_pass);

    $sql = 'SELECT * FROM `supplier_setting` WHERE `company` = "'.$c.'";';
    $row = $dbh->query($sql);

    foreach( $row as $val ){
        $y_appid = $val['y1_appid'];
        $y_secret = $val['y1_secret'];
        $y_url = $val['y1_url'];
        $y_cert_ver = $val['y1_cert_ver'];
    }

    //		var_dump($raku_api);
    //		echo "<hr>";
    $callback_url = $config[ENV][$path]['callback_url'];

    $json = file_get_contents($dir . '/token1.json');
    // 返り値の表示
    $data = json_decode($json, true);
    $data['refresh_token'];
    //$res = mb_convert_encoding($res, "UTF-8");

    // ヘッダ設定
    $key = file_get_contents($dir . '/public.key');
    $auth_value = $y_url . ":" . time();
    $public_key = openssl_pkey_get_public($key);
    openssl_public_encrypt($auth_value, $encrypted_auth_value, $public_key);
    $enc_auth_value = base64_encode($encrypted_auth_value);
    $y_app_secret_base64 = base64_encode($y_appid . ':' . $y_secret);
    $header = [
        'POST /yconnect/v2/token HTTP/1.1',
        'Host: auth.login.yahoo.co.jp',
        'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        'Authorization: Basic ' . $y_app_secret_base64,
        'X-sws-signature:' . $enc_auth_value,
        'X-sws-signature-version:' . $y_cert_ver,
    ];

    $param = array(
        'grant_type'   => 'refresh_token',
        'refresh_token'   => $data['refresh_token']
    );

    // var_dump($param);

    $ch = curl_init(TOKEN_URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($param));
    $response = curl_exec($ch);
    $result = json_decode($response, true);
    if (isset($result['error'])) {
        $options = [
            $path => TOKEN_URL,
        ];
        Util::mail($result, $options);
    }
    curl_close($ch);

    // 任意でレスポンスデータの判定処理を追加してください。
    $token = json_decode($response, true);
    $response = array_merge($token, array('refresh_token' => $data['refresh_token']));
    $response = json_encode($response);
    file_put_contents($dir . '/token1.json', $response);
    
    // 実行した結果は下記に別枠で記載しております。
    //var_dump($token);

    $header = [
        'POST /ShoppingWebService/V1/orderList HTTP/1.1',
        'Host: circus.shopping.yahooapis.jp',
        'Authorization: Bearer ' . $data['access_token'],
        'X-sws-signature:' . $enc_auth_value,
        'X-sws-signature-version:' . $y_cert_ver,
    ];
    $url = 'https://circus.shopping.yahooapis.jp/ShoppingWebService/V1/orderList';

    $startDate = new DateTime('now');
    $startDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));
    $endDate = new DateTime('now');
    $endDate->setTimeZone( new DateTimeZone('Asia/Tokyo'));

    $startDatetime = $startDate->modify('-7 days')->format('YmdHis'); //期間検索開始日時(YYYY-MM-DDThh:mm:ss+09:00)
    $endDatetime = $endDate->format('YmdHis');   //期間検索終了日時(YYYY-MM-DDThh:mm:ss+09:00)

    // リクエスト内容は任意の内容に変更してください。
    $param = '
<Req>
<Search>
<Condition>
<OrderTimeFrom>' . $startDatetime . '</OrderTimeFrom>
<OrderTimeTo>' . $endDatetime . '</OrderTimeTo>
</Condition>
<Result>100</Result>
<Sort>-order_time</Sort>
<Field>OrderId,OrderTime</Field>
</Search>
<SellerId>' . $y_url . '</SellerId>
</Req>';

    // 必要に応じてオプションを追加してください。
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_URL,            $url);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $param);

    $response = curl_exec($ch);
    //file_put_contents("./log.txt", date("Y-m-d H:i:s") . " " . $response . "\n\n", FILE_APPEND);
    curl_close($ch);

//    print_r($response);

    $response = simplexml_load_string($response);
    if (!isset($response->Status) || ($response->Status != 'OK')) {
        $options = [
            $path => $url,
        ];
        Util::mail($response, $options);
    }

    //受注リスト
    $OrderList = $response->Search->OrderInfo;

    //print_r($OrderList);

    foreach ($OrderList as $order) {
        $orderNumber = $order->OrderId;
        $orderDatetime =  $order->OrderTime;


    $header = [
        'POST /ShoppingWebService/V1/orderInfo HTTP/1.1',
        'Host: circus.shopping.yahooapis.jp',
        'Authorization: Bearer ' . $data['access_token'],
        'X-sws-signature:' . $enc_auth_value,
        'X-sws-signature-version:' . $y_cert_ver,
    ];


    $urls = 'https://circus.shopping.yahooapis.jp/ShoppingWebService/V1/orderInfo';

// リクエスト内容は任意の内容に変更してください。
$params = '
<Req>
<Target>
<OrderId>'.$orderNumber.'</OrderId>
<Field>OrderId,Version,ParentOrderId,ChildOrderId,DeviceType,MobileCarrierName,IsSeen,IsSplit,CancelReason,CancelReasonDetail,IsRoyalty,IsRoyaltyFix,IsSeller,IsAffiliate,IsRatingB2s,NeedSnl,OrderTime,LastUpdateTime,Suspect,SuspectMessage,OrderStatus,StoreStatus,RoyaltyFixTime,SendConfirmTime,SendPayTime,PrintSlipTime,PrintDeliveryTime,PrintBillTime,BuyerComments,SellerComments,Notes,OperationUser,Referer,EntryPoint,HistoryId,UsageId,UseCouponData,TotalCouponDiscount,ShippingCouponFlg,ShippingCouponDiscount,CampaignPoints,IsMultiShip,MultiShipId,IsReadOnly,IsFirstClassDrugIncludes,IsFirstClassDrugAgreement,IsWelcomeGiftIncludes,YamatoCoopStatus,FraudHoldStatus,PublicationTime,IsYahooAuctionOrder,YahooAuctionMerchantId,YahooAuctionId,IsYahooAuctionDeferred,YahooAuctionCategoryType,YahooAuctionBidType,YahooAuctionBundleType,GoodStoreStatus,CurrentGoodStoreBenefitApply,CurrentPromoPkgApply,LineGiftOrderId,IsLineGiftOrder,PayStatus,SettleStatus,PayType,PayKind,PayMethod,PayMethodName,SellerHandlingCharge,PayActionTime,PayDate,PayNotes,SettleId,CardBrand,CardNumber,CardNumberLast4,CardExpireYear,CardExpireMonth,CardPayType,CardHolderName,CardPayCount,CardBirthDay,UseYahooCard,UseWallet,NeedBillSlip,NeedDetailedSlip,NeedReceipt,AgeConfirmField,AgeConfirmValue,AgeConfirmCheck,BillAddressFrom,BillFirstName,BillFirstNameKana,BillLastName,BillLastNameKana,BillZipCode,BillPrefecture,BillPrefectureKana,BillCity,BillCityKana,BillAddress1,BillAddress1Kana,BillAddress2,BillAddress2Kana,BillPhoneNumber,BillEmgPhoneNumber,BillMailAddress,BillSection1Field,BillSection1Value,BillSection2Field,BillSection2Value,PayNo,PayNoIssueDate,ConfirmNumber,PaymentTerm,IsApplePay,LineGiftPayMethodName,ShipStatus,ShipMethod,ShipMethodName,ShipRequestDate,ShipRequestTime,ShipNotes,ShipCompanyCode,ReceiveShopCode,ShipInvoiceNumber1,ShipInvoiceNumber2,ShipInvoiceNumberEmptyReason,ShipUrl,ArriveType,ShipDate,ArrivalDate,NeedGiftWrap,GiftWrapCode,GiftWrapType,GiftWrapMessage,NeedGiftWrapPaper,GiftWrapPaperType,GiftWrapName,Option1Field,Option1Type,Option1Value,Option2Field,Option2Type,Option2Value,ShipFirstName,ShipFirstNameKana,ShipLastName,ShipLastNameKana,ShipZipCode,ShipPrefecture,ShipPrefectureKana,ShipCity,ShipCityKana,ShipAddress1,ShipAddress1Kana,ShipAddress2,ShipAddress2Kana,ShipPhoneNumber,ShipEmgPhoneNumber,ShipSection1Field,ShipSection1Value,ShipSection2Field,ShipSection2Value,ReceiveSatelliteType,ReceiveSatelliteSettleMethod,ReceiveSatelliteMethod,ReceiveSatelliteCompanyName,ReceiveSatelliteShopCode,ReceiveSatelliteShopName,ReceiveSatelliteShipKind,ReceiveSatelliteYahooCode,ReceiveSatelliteCertificationNumber,CollectionDate,CashOnDeliveryTax,NumberUnitsShipped,ShipRequestTimeZoneCode,ShipInstructType,ShipInstructStatus,ReceiveShopType,ReceiveShopName,ExcellentDelivery,IsEazy,EazyDeliveryCode,EazyDeliveryName,IsSubscription,SubscriptionId,SubscriptionContinueCount,SubscriptionCycleType,SubscriptionCycleDate,IsLineGiftShippable,ShippingDeadline,UseGiftCardData,PayCharge,ShipCharge,GiftWrapCharge,Discount,Adjustments,SettleAmount,UsePoint,GiftCardDiscount,TotalPrice,SettlePayAmount,IsGetPointFixAll,TotalMallCouponDiscount,IsGetStoreBonusFixAll,LineGiftCharge,LineId,ItemId,Title,SubCode,SubCodeOption,ItemOption,Inscription,IsUsed,ImageId,IsTaxable,ItemTaxRatio,Jan,ProductId,CategoryId,AffiliateRatio,UnitPrice,NonTaxUnitPrice,Quantity,PointAvailQuantity,ReleaseDate,PointFspCode,PointRatioY,PointRatioSeller,UnitGetPoint,IsGetPointFix,GetPointFixDate,CouponData,CouponDiscount,CouponUseNum,OriginalPrice,OriginalNum,LeadTimeText,LeadTimeStart,LeadTimeEnd,PriceType,PickAndDeliveryCode,PickAndDeliveryTransportRuleType,YamatoUndeliverableReason,StoreBonusRatioSeller,UnitGetStoreBonus,IsGetStoreBonusFix,GetStoreBonusFixDate,ItemYahooAucId,ItemYahooAucMerchantId,SellerId,LineGiftAccount,IsLogin,FspLicenseCode,FspLicenseName,GuestAuthId</Field>
</Target>
<SellerId>'.$y_url.'</SellerId>
</Req>';


    // 必要に応じてオプションを追加してください。
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_URL,            $urls);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $params);

    $responses = curl_exec($ch);
    //file_put_contents("./log.txt", date("Y-m-d H:i:s") . " " . $responses . "\n\n", FILE_APPEND);
    curl_close($ch);

    $responses = str_replace('<![CDATA[', '', $responses);
    $responses = str_replace(']]>', '', $responses);

    // タグ内の内容を取得する正規表現
    //<BuyerComments>タグ内の"<>"を"()"に置換
    $pattern = '/<BuyerComments>(.*?)<\/BuyerComments>/s';
    $responses = preg_replace_callback($pattern, function ($matches) {
        $tagContent = $matches[1];
        $tagContent = str_replace('<', '(', $tagContent);
        $tagContent = str_replace('>', ')', $tagContent);
        return '<BuyerComments>' . $tagContent . '</BuyerComments>';
    }, $responses);

    //echo $order_id;
    //print_r($responses);

    // XML文字列をSimpleXMLを使ってPHPオブジェクトにする
    $responses = str_replace('&','&amp;',$responses);
	$res = simplexml_load_string($responses);
	
    if (!isset($res->Result->Status) || ($res->Result->Status != 'OK')) {
        $options = [
            $path => $urls,
        ];
        Util::mail($res, $options);
    }

    //rint_r($res);
    $orderProgress = $res->Result->OrderInfo->OrderStatus;
    $orderDatetime = $res->Result->OrderInfo->OrderTime;

    $sei = $res->Result->OrderInfo->Pay->BillLastName;
    $mei = $res->Result->OrderInfo->Pay->BillFirstName;
    $name = $sei." ".$mei;

    $seiKana = $res->Result->OrderInfo->Pay->BillLastNameKana;
    $meiKana = $res->Result->OrderInfo->Pay->BillFirstNameKana;
    $nameKana = $seiKana." ".$meiKana;

    $zip = $res->Result->OrderInfo->Pay->BillZipCode;

    $prefecture = $res->Result->OrderInfo->Pay->BillPrefecture;
    $city = $res->Result->OrderInfo->Pay->BillCity;
    $subAddress1 = $res->Result->OrderInfo->Pay->BillAddress1;
    $subAddress2 = $res->Result->OrderInfo->Pay->BillAddress2;
    $address = $prefecture.$city.$subAddress1." ".$subAddress2;

    $addressKana = "";

    $phoneNumber = $res->Result->OrderInfo->Pay->BillPhoneNumber;
           
    $emailAddress = $res->Result->OrderInfo->Pay->BillMailAddress;

    $settlementMethodCode = $res->Result->OrderInfo->Pay->PayKind;

    $settlementMethod = $res->Result->OrderInfo->Pay->PayMethodName;

    $remarks = $res->Result->OrderInfo->BuyerComments;

    $sendersei = $res->Result->OrderInfo->Ship->ShipLastName;
    $sendermei = $res->Result->OrderInfo->Ship->ShipFirstName;
    $senderName = $sendersei." ".$sendermei;

    $senderseikana = $res->Result->OrderInfo->Ship->ShipLastNameKana;
    $sendermeikana = $res->Result->OrderInfo->Ship->ShipFirstNameKana;
    $senderNameKana = $senderseikana." ".$sendermeikana;

    $senderZip = $res->Result->OrderInfo->Ship->ShipZipCode;

    $senderprefecture = $res->Result->OrderInfo->Ship->ShipPrefecture;
    $sendercity = $res->Result->OrderInfo->Ship->ShipCity;
    $sendersubAddress1 = $res->Result->OrderInfo->Ship->ShipAddress1;
    $sendersubAddress2 = $res->Result->OrderInfo->Ship->ShipAddress2;
    $senderAddress = $senderprefecture.$sendercity.$sendersubAddress1." ".$sendersubAddress2;

    $senderAddressKana = "";

    $senderPhoneNumber = $res->Result->OrderInfo->Ship->ShipPhoneNumber;

    $TotalCouponDiscount = $res->Result->OrderInfo->TotalCouponDiscount;

    $i = 0;
    foreach ($res->Result->OrderInfo->Item as $item) {
        $itemNumber = $item->ItemId;
        $itemName = $item->Title;
        $price = $item->NonTaxUnitPrice;
        $units = $item->Quantity;
        $opt1 = $item->ItemOption->Value;
        //$opt1 = str_replace("パネルカラーをお選びください:", "", $opt);
        //preg_match('/パネルをお選び下さい:(.*+)/', $opt, $m);
        //$opt1 = $m[1];
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

        $getsql = 'INSERT INTO `cart_raw_data` (`ukey`, `company`, `mall`, `url`, `order_id`, `name`, `pref`, `city`, `model`, `unit`, `opt1`, `opt2`, `orderdate`, `created`) values ("'.$ukey.'", "'.$c.'", "Yahoo", "'.$y_url.'", "'.$orderNumber.'", "'.$name.'", "'.$senderprefecture.'", "'.$sendercity.'", "'.$itemNumber.'", "'.$units.'", "'.$opt1.'", "'.$opt2.'", "'.$orderDatetime.'", NOW()) ON DUPLICATE KEY UPDATE `name` = "'.$name.'", `pref` = "'.$senderprefecture.'", `city` = "'.$sendercity.'", `unit` = "'.$units.'", `opt1` = "'.$opt1.'", `opt2` = "'.$opt2.'";';

        echo $getsql."<br/>";
        Util::log($getsql);
        /*
          $insert_pat = "/-|^mitsumori(.*)|お時間指定料|車種ご指定料（ゲート車）|部材|木台/";
          if(!preg_match($insert_pat, $model)){
          $dbh->query($getsql);
          }
        */
        $dbh->query($getsql);


        if ($i != 0) {
            $TotalCouponDiscount = 0;
        }

        $getsqls = 'INSERT INTO `cart_raw_search` (`ukey`, `company`, `mall`, `url`, `orderNumber`, `orderProgress`, `orderDatetime`, `name`, `nameKana`, `zip`, `address`, `addressKana`, `phoneNumber`, `emailAddress`, `senderName`, `senderNameKana`, `senderZip`, `senderAddress`, `senderAddressKana`, `senderPhoneNumber`, `itemName`, `itemNumber`, `price`, `units`, `settlementMethodCode`, `settlementMethod`, `remarks`, `updated`, `discount`, `flag`) values ("'.$ukey.'", "'.$c.'", "Yahoo", "'.$y_url.'", "'.$orderNumber.'", "'.$orderProgress.'", "'.$orderDatetime.'", "'.$name.'", "'.$nameKana.'", "'.$zip.'", "'.$address.'", "'.$addressKana.'", "'.$phoneNumber.'", "'.$emailAddress.'", "'.$senderName.'", "'.$senderNameKana.'", "'.$senderZip.'", "'.$senderAddress.'", "'.$senderAddressKana.'", "'.$senderPhoneNumber.'", "'.$itemName.'", "'.$itemNumber.'", "'.$price.'", "'.$units.'", "'.$settlementMethodCode.'", "'.$settlementMethod.'", "'.$remarks.'", NOW(), "'.$TotalCouponDiscount.'", "0") ON DUPLICATE KEY UPDATE `orderProgress` = "'.$orderProgress.'", `orderDatetime` = "'.$orderDatetime.'", `name` = "'.$name.'", `nameKana` = "'.$nameKana.'", `zip` = "'.$zip.'", `address` = "'.$address.'", `addressKana` = "'.$addressKana.'", `phoneNumber` = "'.$phoneNumber.'", `emailAddress` = "'.$emailAddress.'", `senderName` = "'.$senderName.'", `senderNameKana` = "'.$senderNameKana.'", `senderZip` = "'.$senderZip.'", `senderAddress` = "'.$senderAddress.'", `senderAddressKana` = "'.$senderAddressKana.'", `senderPhoneNumber` = "'.$senderPhoneNumber.'", `itemName` = "'.$itemName.'", `itemNumber` = "'.$itemNumber.'", `price` = "'.$price.'", `units` = "'.$units.'", `settlementMethodCode` = "'.$settlementMethodCode.'", `settlementMethod` = "'.$settlementMethod.'", `remarks` = "'.$remarks.'", `discount` = "'.$TotalCouponDiscount.'";';

        echo $getsqls."<br/>";
        Util::log($getsql);
        $dbh->query($getsqls);
        //file_put_contents("./log.txt", date("Y-m-d H:i:s") . " " . $getsql . "\n\n", FILE_APPEND);
        $i++;
    }

    }

} catch (PDOException $e) {
      print('Error:'.$e->getMessage());
      die();
  }


?>
