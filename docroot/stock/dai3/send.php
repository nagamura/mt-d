<?php
$data = array();//初期化
foreach ($_POST as $key => $val) {
	$data[$key] = $val;//連想配列で格納
}

try{
	$dbh = new PDO($dsn, $db_user, $db_pass);
	$sqluser = 'SELECT `depart` FROM `users` WHERE `email` = "'.$_SESSION["userData"]["email"].'";';
	$rowsuser = $dbh->query($sqluser);

	// 取得したデータを出力
	foreach($rowsuser as $valueuser ){
		$depart = $valueuser['depart'];
	}

    $sqlid = 'SELECT `id` FROM `supplier_stock_id`;';
    $rowsid = $dbh->query($sqlid);
    // 取得したデータを出力
    foreach($rowsid as $valueid ){
        $order_id = $valueid['id'] . "_" . $_SESSION['userData']['employee_code'];
    }

    $next_id = $order_id + 1;

    $i = 0;
    foreach($data['supplier'] as $supplier){
        $j=0;
        foreach($supplier as $sup){
            $model = $data['model'][$i];
            $origin_model = $data['origin_model'][$i];
            $set = $data['set'][$i];
            $unit = $data['unit'][$i];
            $memo = $data['memo'][$i];
            $sha_id = hash('sha256', $data['ukey'][$i].'-'.$sup);

            $sqlsup = 'SELECT `name`, `tomail` FROM `users` WHERE `scd` = "'.$sup.'" AND `tomail` != "";';
            $rowsup = $dbh->query($sqlsup);
            // 取得したデータを出力
            foreach($rowsup as $valsup ){
                $name = $valsup['name'];
                $tomail = $valsup['tomail'];
            }

            if($name){
                $mailhead[$sup] = $tomail;
                $mailbody[$sup] .= $model.' '.$set.''.$unit.'\n'.$memo.'\n';
            }

            $sql = "INSERT INTO `services`.`supplier_stock_items` (`id`,`hash_id`,`ukey`,`company`,`mall`,`url`,`order_id`,`case_no`,`name`,`address`,`model`,`set`,`unit`,`opt1`,`opt2`,`opt3`,`opt4`,`depart`,`email`,`inputter`,`supplier`,`read1`,`read2`,`is_hurry`,`is_empty`,`is_close`,`status`,`condition`,`created`,`update_time`)
VALUES (NULL ,
		'".$sha_id."',
		".$dbh->quote($data['ukey'][$i]).",
		'".$data['company']."',
		".$dbh->quote($data['mall']).",
		'".$data['url']."',
		'".$order_id."',
		".$dbh->quote($data['case_no']).",
		'".$data['name']."',
		".$dbh->quote($data['address']).",
		".$dbh->quote($model).",
		'".$set."',
		'".$unit."',
		".$dbh->quote($memo).",
		'',
		'',
		'',
		'".$depart."',
		'".$data['email']."',
		'".$data['inputter']."',
		'".$sup."',
		'0',
		'0',
		'". (($data['hurry'] == 0) ? 0 : 1) . "',
		'0',
		'0',
		'0',
		'0',
		NOW(),
		CURRENT_TIMESTAMP);";
            $row = $dbh->query($sql);
            //エラー処理ここから
            $error = $dbh->errorInfo();

            if($error[1] == "1062"){
                $result_txt .= '<div style="color:#FF0000;line-height: 200%;">【失敗】注文番号「'.$order_id."」での「".$model."」の仕入先CD「".$sup."」への在庫確認は既に在庫確認登録済です。</div>";
            }else{
                $result_txt .= '<div style="color:#000000;line-height: 200%;">【成功】注文番号「'.$order_id."」での「".$model."」の仕入先CD「".$sup."」への在庫確認は正しく登録できました。</div>";
            }
            //エラー処理ここまで
			$e_hash_id = '';
            $ups_sql = 'UPDATE `cart_raw_data` SET `status` = "9" WHERE `ukey` = "'.$data['case_no'].'-'.$origin_model.'";';
            $ups_row = $dbh->query($ups_sql);

            $j++;
        }

        $i++;

    }

	if($next_id){
		$idup = 'UPDATE `supplier_stock_id` SET `id` = "'.$next_id.'";';
		$rowsup = $dbh->query($idup);
	}


}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

//Warningの元
if($mailhead){
    foreach ($mailhead as $key => $v) {
        $to = $v;
        $message = $mailbody[$key];

        $subject = "TEST";
        $headers = "From: koubai@mitax.co.jp";
        mb_send_mail($to, $subject, $message, $headers); 
    }

}


?>
<html>
<head>
	<style type="text/css">
	<!--
	body {
		background-color: #f6f6f6;
	}

	table {
		border-collapse: collapse;
		font-size: 15px;
	}

	input[type="submit"] {
		border-radius: 10px;
		color: #ffffff !important;
		font-weight: bold;
		display: inline-block;
		position: relative;
		text-align: center;
		box-shadow: 0 1px 2px 0 rgba(100, 100, 100, 0.5);
		box-sizing: border-box;
		white-space: nowrap;
		background-color: #ec4f3e;
		font-size: 17px;
		padding: 23px 48px 20px;
		border: 0;
		font-family: 'メイリオ', Meiryo, 'ＭＳ Ｐゴシック', sans-serif;
		cursor: pointer;
		margin: 0;
		-webkit-appearance: none;
		opacity: 1;
		//	width: 100%;
		line-height: 1.4;
		outline: none;
	}

	textarea {
		width: 300px;
		height: 40px;
		line-height: 1.5em;
		margin: auto;
		padding: 9px 10px;
	}

	th {
		padding: 5px 10px;
		white-space: nowrap;
	}

	td {
		padding: 15px 10px;
	}

	.ub {
		border-bottom: 1px solid #EFEFEF;
	}

	input[type="submit"],
	input[type="text"],
	input[type="date"],
	input[type="time"],
	input[type="number"],
	input[type="tel"],
	select,
	textarea,
	button {
		-moz-appearance: none;
		-webkit-appearance: none;
		-webkit-box-shadow: none;
		box-shadow: none;
		outline: none;
		border: none;
	}

	input[type="text"],
	input[type="date"],
	input[type="time"],
	input[type="number"],
	input[type="tel"],
	select,
	textarea {
		background-color: #ffffff;
		border: 1px #cccccc solid;
		//	display: block;
		font-size: 16px;
		padding: 9px 10px;
		transition: 0.8s;
		border-radius: 0;
		//	float: left;
	}

	input[type="time"] {
		width: 85px;
		padding: 6px 10px;
	}


	input[type="submit"] {
		border-radius: 10px;
		color: #ffffff !important;
		font-weight: bold;
		display: inline-block;
		position: relative;
		text-align: center;
		box-shadow: 0 1px 2px 0 rgba(100, 100, 100, 0.5);
		box-sizing: border-box;
		white-space: nowrap;
		background-color: #ec4f3e;
		font-size: 17px;
		padding: 23px 48px 20px;
		border: 0;
		font-family: 'メイリオ', Meiryo, 'ＭＳ Ｐゴシック', sans-serif;
		cursor: pointer;
		margin: 0;
		-webkit-appearance: none;
		opacity: 1;
		//	width: 100%;
		line-height: 1.4;
		outline: none;
	}

	input[type="text"]:focus,
	input[type="date"]:focus,
	input[type="time"]:focus,
	input[type="number"]:focus,
	input[type="tel"]:focus,
	textarea:focus,
	select:focus {
		background: #aadaf0;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	}
	-->
	</style>



</head>

<body>
	<div>在庫確認を送信しました。</div>
	<?php echo $result_txt; ?>
	<div><input type="button" value="閉じる" onclick="window.opener.location.reload(); window.close();"></div>
</body>

</html>
