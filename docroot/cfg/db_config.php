<?php
$dsn = 'mysql:host=localhost; dbname=services; charset=utf8mb4';
$db_user = 'root';
$db_pass = '';

try{
	$dbh = new PDO($dsn, $db_user, $db_pass);
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$insert_pat = "/-|^mitsumori(.*)|お時間指定料|車種ご指定料（ゲート車）|部材|木台/";
?>