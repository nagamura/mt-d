<?php
session_cache_limiter('private_no_expire');
session_start();
include( $_SERVER['DIR'] . "/utils/outh_provider.php");
include( $_SERVER['DIR'] . "/utils/token_generate.php");

require_once( $_SERVER['DIR'] . "/cfg/db_config.php");

$data = array();//初期化
foreach ($_POST as $key => $val) {
    $data[$key] = $val;//連想配列で格納
}

try {
    $dbh = new PDO($dsn, $db_user, $db_pass);

    $i = 0;

    $sqlsup = 'SELECT `scd`, `display_name`, `canStock` FROM `users` WHERE `scd` != "0" AND `status` != 0;';
    $rowsup = $dbh->query($sqlsup);
    $supplier_list = $rowsup -> fetchAll(PDO::FETCH_ASSOC);

    $s=0;
    foreach($supplier_list as $value){
	$scd_list[] = $value['scd'];
	$sup_name_list[] = $value['display_name'];
	$sup_status_list[] = $value['canStock'];
	if($value['canStock'] == "0"){
	    $table_head_parts .= '<th>'.$value['display_name'].'<br><input type="checkbox" class="sup['.$s.'] " disabled="disabled"></th>';
	}else{
	    $table_head_parts .= '<th>'.$value['display_name'].'<br><input type="checkbox" class="sup['.$s.'] allcheck"></th>';
	}
	$s++;
    }

    $table_head = '<tr><th>型番</th><th>数量</th>';
    $table_head .= $table_head_parts;
    $table_head .= '<th>備考</th><th>コピー</th></tr>';

    if (preg_match("/\-2$/",$model)) {
	$model = rtrim($model, '-2');
    }

    $ukey = $data['ukey'][$i];
    $origin_model = $data['origin_model'][$i];

    $sys = $data['sys'][$i];
    $set = $data['set'][$i];
    $unit = $data['unit'][$i];
    $memo = $data['memo'][$i];


    $sql = 'SELECT DISTINCT `model`, `scd` FROM `products` WHERE `model` = "'.$model.'" AND `cd` < "90000000"';
    $sqls = 'SELECT COUNT(*) AS `cnt` FROM `products` WHERE `model` = "'.$model.'" AND `cd` < "90000000"';

    $row = $dbh->query($sql);
    $rows = $dbh->query($sqls);

    $makerList = $row -> fetchAll(PDO::FETCH_ASSOC);
    $makerCount = $rows -> fetchColumn();

    $scd = array_column($makerList, 'scd');

    $maker_parts = '';
    $supplier_list = $scd_list;

    $j = 0;
    if ($makerCount != "0"){
	foreach($supplier_list as $supplier){
	    if ($sup_status_list[$j] == 0) {
		$maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']" value="'.$supplier.'" disabled="disabled" ></td>';
	    } elseif($sup_status_list[$j] == 9) {
		$maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']" value="'.$supplier.'"></td>';
	    } elseif (in_array($supplier, $scd)) {
		if (count($scd) == 1) {
		    $maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']" value="'.$supplier.'" checked ></td>';
		} else {
		    $maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']" value="'.$supplier.'"></td>';
		}
	    } else {
		$maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']" value="'.$supplier.'" disabled></td>';
	    }
	    $j++;
	}
    } else {
	foreach($supplier_list as $supplier){
	    $maker_parts .= '<td style="text-align: center;"><input type="checkbox" name="supplier['.$i.']['.$j.']" class="group'.$i.' sup['.$j.']"  value="'.$supplier.'"></td>';
	    $j++;
	}
    }
    if ($model) {
	$table_parts .= '<tr><td>'.$model.'</td><td>'.$set.$unit.'</td>'.$maker_parts.'<td><textarea name="memo['.$i.']" id="memo['.$i.']">'.$memo.'</textarea></td><td>';
	if ($i != 0) {
	    $table_parts .= '	<button class="copy_clipboard" id="copy['.$i.']" name="copy['.$i.']">上の備考をコピー</button>';
	} else {
	    $table_parts .= '-';
	}
	$table_parts .= '</td>
<input type="hidden" name="ukey['.$i.']" id="ukey['.$i.']" value="'.$ukey.'" />
<input type="hidden" name="model['.$i.']" id="model['.$i.']" value="'.$model.'" />
<input type="hidden" name="origin_model['.$i.']" id="origin_model['.$i.']" value="'.$origin_model.'" />
<input type="hidden" name="set['.$i.']" id="set['.$i.']" value="'.$set.'" />
<input type="hidden" name="unit['.$i.']" id="unit['.$i.']" value="'.$unit.'" />
</tr>';
	}

	$js_rule .= "
	$('[name^=\"supplier[".$i."]\"]').each(function() {
        $(this).rules('add', {
            require_from_group: [1, $('[class^=\"group".$i."\"]')],
            messages: {
                require_from_group: \"1つ以上選択して下さい。\"
            }
        });
    });
	    ";

	$i++;
    }

    $sql_tanto = 'SELECT * FROM `users` WHERE `depart` = "'.$_SESSION['userData']['depart'].'" AND `stock_form_status` = "1" ORDER BY `employee_code` ASC;';
    $row_tanto = $dbh->query($sql_tanto);
    $tanto = $row_tanto -> fetchAll(PDO::FETCH_ASSOC);
    foreach($tanto as $valss){
	$tanto_email = $valss['email'];
	$tanto_name = $valss['display_name'];
	$tanto_code = $valss['employee_code'];
	if($tanto_email == $_SESSION['userData']['email'] ){
	    $tanto_option .= '<option value="'.$tanto_email.'" selected>'.$tanto_name.'('.$tanto_code.')</option>';
	}else{
	    $tanto_option .= '<option value="'.$tanto_email.'">'.$tanto_name.'('.$tanto_code.')</option>';
	}
    }

    $tanto_parts = '<select name="email">';
    $tanto_parts .= $tanto_option;
    $tanto_parts .= '</select>';

} catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>
<html>
  <head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    <script>
     $(document).ready(function() {
	 $("#form").validate({
	     rules: {
		 // other rules
	     },
	     errorPlacement: function(error, element) {
		 if ($("#error").text() != "1つ以上選択して下さい。") {
		     error.appendTo("#error");
		 }
	     }
	 });

	 <?php echo $js_rule; ?>

     });
    </script>




    <script>
     $(function() {
	 $(document).on('click', '.copy_clipboard', function() {
	     var copy_id = $(this).attr('id');
	     var copy_cnt = copy_id.match(/\[(.+)\]/)[1];
	     var copy_cnt2 = Number(copy_cnt) - 1;
	     var copy_txt = $('#memo\\[' + copy_cnt2 + '\\]').val();
	     $('#memo\\[' + copy_cnt + '\\]').val(copy_txt);
	     return false;
	 });
     });

     $(function() {
	 // 1. 「全選択」する
	 $(document).on('click', '.allcheck', function() {
	     var check_id = $(this).attr('class');
	     var check_cnt = check_id.match(/\[(.+)\]/)[1];
	     $('.sup\\[' + check_cnt + '\\]').prop('checked', this.checked);
	 });
	 // 2. 「全選択」以外のチェックボックスがクリックされたら、
	 $(document).on('click', '.allcheck', function() {
	     var check_id = $(this).attr('class');
	     var check_cnt = check_id.match(/\[(.+)\]/)[1];
	     if ($('.sup\\[' + check_cnt + '\\]:checked').length == $('.sup\\[' +
								      check_cnt + '\\]:input').length) {
		 // 全てのチェックボックスにチェックが入っていたら、「全選択」 = checked
		 $('.sup\\[' + check_cnt + '\\]').prop('checked', true);
	     } else {
		 // 1つでもチェックが入っていたら、「全選択」 = checked
		 $('.sup\\[' + check_cnt + '\\]').prop('checked', false);
	     }

	 });
     });
    </script>
    <script>
     $(function() {
	 $('#kaijyo').click(function() {
	     $('input').prop('disabled', false);
	     return false;
	 });
     });
    </script>
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

     .wrap {
	 display: block;
	 margin-bottom: 20px;
     }

     .ttl {
	 font-weight: bold;
     }

     #news {
	 display: block;
	 width: 80%;
	 margin-bottom: 25px;
	 background-color: #FFFFFF;
	 padding: 10px;
     }
     -->
    </style>



  </head>

  <body>
    <?php require_once("../news_display.php"); ?>


    <form action='confirm.php' method="post" id="form">
      <div>注文情報</div>
      <p>注文番号：<input type="hidden" name="case_no"
				value="<?php echo $data['case_no']; ?>"><?php echo $data['case_no']; ?>｜モール：<input
														   type="hidden" name="mall" value="<?php echo $data['mall']; ?>"><input type="hidden"
																							       name="company"
																							       value="<?php echo $data['company']; ?>"><?php echo $data['mall']; ?>｜URL：<input
																																	    type="hidden" name="url" value="<?php echo $data['url']; ?>"><?php echo $data['url']; ?>
      </p>
      <p>ご注文者：<input type="hidden" name="name"
				value="<?php echo $data['name']; ?>"><?php echo $data['name']; ?></p>
      <p>納品先<span>※原則「○○県○○市」までの入力とする。</span></p>
      <p><input type="text" name="address" value="<?php echo $data['address']; ?>" size="100"></p>
      <p>急ぎ案件：<input type="checkbox" name="hurry" value="1">急ぎ案件</p>
      <p>営業担当者：<?php echo $tanto_parts; ?><input type="hidden" name="inputter"
							     value="<?php echo $_SESSION["userData"]["id"]; ?>"></p>
      <p>&nbsp;</p>
      <button type="button" id="kaijyo">全仕入先を選択可能にする(購買課及び第3施設部専用)</button>
      <?php
      echo '<table>';
      echo $table_head;
      echo $table_parts;
      ?>

      <tr>
	<td colspan="14" style="text-align:center;">&nbsp;</td>
      </tr>
      <tr>
	<td colspan="14" style="text-align:center;">

	  <input type="button" value="閉じる"
		       onclick="window.opener.location.reload(); window.close();">

	  <input type="submit" value="送信" />
	  <div id="error"></div>
	</td>
      </tr>
		</table>


    </form>

  </body>

</html>
