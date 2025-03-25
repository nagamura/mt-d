<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script>
$(function(){
    // フォームカウント
    var frm_cnt = 4;

    // clone object
    $(document).on('click', 'span.add', function() {
	var original = $('#form_block\\[' + frm_cnt + '\\]');
	var originCnt = frm_cnt;
	var originVal = $("input[name='sys\\[" + frm_cnt + "\\]']:checked").val();

	frm_cnt++;

	original
	    .clone()
	    .hide()
	    .insertAfter(original)
	    .attr('id', 'form_block[' + frm_cnt + ']') // クローンのid属性を変更。
	    .find("input[type='radio'][checked]").prop('checked', true)
	    .end() // 一度適用する
	    .find('input, textarea, select, button').each(function(idx, obj) {
		$(obj).attr({
		    id: $(obj).attr('id').replace(/\[[0-9]+\]+$/, '[' + frm_cnt + ']'),
		    name: $(obj).attr('name').replace(/\[[0-9]+\]+$/, '[' + frm_cnt + ']')
		})
		$(obj).val('');
	    });

	$("select option[value='式']").prop('selected', true);
	$("#set\\[" + frm_cnt + "\\]").val('1');
	//	$("input[name='sys\\[" + frm_cnt + "\\]'").eq(0).val('同時');
	//	$("input[name='sys\\[" + frm_cnt + "\\]'").eq(1).val('個別');


	// clone取得
	var clone = $('#form_block\\[' + frm_cnt + '\\]');
	clone.find('span.close').show();
	clone.slideDown('slow');

	// originalラジオボタン復元
	original.find("input[name='sys\\[" + originCnt + "\\]'][value='" + originVal + "']").prop('checked', true);
    });

    // close object
    $(document).on('click', 'span.close', function() {
	var removeObj = $(this).closest(".form-block[id^='form_block']");
	removeObj.fadeOut('fast', function() {
	    removeObj.remove();
	    // 番号振り直し
	    frm_cnt = 0;
	    $(".form-block[id^='form_block']").each(function(index, formObj) {
		if ($(formObj).attr('id') != 'form_block[0]') {
		    frm_cnt++;
		    $(formObj)
			.attr('id', 'form_block[' + frm_cnt + ']') // id属性を変更。
			.find('input, textarea, select, button').each(function(idx, obj) {
			    $(obj).attr({
				id: $(obj).attr('id').replace(/\[[0-9]+\]+$/, '[' + frm_cnt + ']'),
				name: $(obj).attr('name').replace(/\[[0-9]+\]+$/, '[' + frm_cnt + ']')
			    });
			});
		}
	    });
	});
    });

    $(document).on('click', '.copy_clipboard', function() {
	var copy_id = $(this).attr('id');
	var copy_cnt = copy_id.match(/\[(.+)\]/)[1];
	var copy_cnt2 = Number(copy_cnt) - 1;
	var copy_txt = $('#memo\\[' + copy_cnt2 + '\\]').val();
	$('#memo\\[' + copy_cnt + '\\]').val(copy_txt);
	return false;
    });

});

</script>

<style type="text/css">
<!--
body {
	background-color: #f6f6f6;
}
.form-block {
  position: relative;
  font-size: 12px;
  padding: 10px;
  margin: 0 0 20px 0;
  background: #fff;
//  border: 1px #ccc solid;
//  box-shadow: 0 2px 3px 0 #ddd;
//  -moz-box-shadow: 0 2px 3px 0 #ddd;
//  -webkit-box-shadow: 0 2px 3px 0 #ddd;
}

.form-block .close {
    background-color: #333;
    color: #DDD;
    display: inline-block;
    font-size: 12px;
	padding: 5px 7px;
    text-align: center;
    cursor: pointer;
}

.form-block .add {
	color: #000;
    font-weight: bold;
    display: block;
    font-size: 32px;
    cursor: pointer;
    width: 50px;
    margin: 0 auto;
}
textarea {
	margin: 0px auto -12px;
}


table {
	border-collapse: collapse;
	font-size: 15px;
}

p {
	font-size: 16px;
	font-weight: bold;
//	text-align: center;
	margin: 15px auto;
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
	box-shadow: 0 1px 2px 0 rgba(100,100,100,0.5);
	box-sizing: border-box;
	white-space: nowrap;
	background-color: #ec4f3e;
	font-size: 17px;
	padding: 23px 48px 20px;
	border: 0;
	font-family: 'メイリオ',Meiryo,'ＭＳ Ｐゴシック',sans-serif;
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

input[type="tel"] {
	width: 135px;
	text-align:right;
}

input[type="number"] {
	width: 60px;
	text-align:right;
}

input[type="tel"].input-num {
	width: 110px;
}

.copy_clipboard,
a.copy_clipboard {
  color: #fff;
  background-color: #eb6100;
}
.copy_clipboard:hover,
a.copy_clipboard:hover {
  color: #fff;
  background: #f56500;
}

.btn, a.btn, button.btn {
	font-size: 12px;
    font-weight: 200;
    line-height: 1.5;
    position: relative;
    display: inline-block;
    padding: 9px 12px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    text-align: center;
    /* vertical-align: middle; */
    text-decoration: none;
    letter-spacing: 0.1em;
    color: #FFFFFF;
    border-radius: 0.5rem;
}

textarea {
width: 300px;
height: 40px;
line-height: 1.5em;
margin: auto;
padding: 9px 10px;
}


input[type="number"]::-webkit-outer-spin-button, 
input[type="number"]::-webkit-inner-spin-button { 
	-webkit-appearance: none; 
	margin: 0; 
}

input[type="number"] { 
	-moz-appearance:textfield; 
}

#inputtype {
	float: right;
}

#inputtype input[type="submit"] {
	font-size: 12px;
	font-weight: normal;
	padding: 5px;
}

-->

</style>


</head>
<body>

<div id="inputtype">
<form action="index_bulk.php" method="post">
<input type="submit" value="一括入力方式を標準の入力方式にする" />
<input type="hidden" name="formt" value="b" />
<input type="hidden" name="orderId" value="118930_310" />
<input type="hidden" name="supplier" value="6010" />
<input type="hidden" name="option" value="add" />
</form>
</div>

<form action='supplier.php' method="post">

<div>店舗名</div>
<p>会社名：イーセツビ<input type="hidden" name="company" value="e">｜モール：楽天<input type="hidden" name="mall" value="楽天">｜URL：e-setsubi<input type="hidden" name="url" value="e-setsubi"></p>
<p>&nbsp;</p>

<input type="hidden" name="order_id" value="118930_310">
<input type="hidden" name="option" value="add">

<div>案件情報</div>
<p>案件番号：320228-20240628-0235121905<input type="hidden" name="case_no" value="320228-20240628-0235121905">
</p>
<p>営業担当者：平田(310)<input type="hidden" name="email" value="hirata@mitax.co.jp">
<input type="hidden" name="inputter" value="113"></p>
<p>納品先 ※原則「○○県○○市」までの入力とする 
<p>北海道室蘭市<input type="hidden" name="address" value="北海道室蘭市"></p>
<p>&nbsp;</p>
</p>
<p>&nbsp;</p>
<!--
<div>急ぎ案件</div>
<p><input type="checkbox" name="hurry" value="1">急ぎ案件</p>
<p>&nbsp;</p>
-->
<table>
	<thead>
	<tr><th>型番</th><th>数量</th><th>単位</th><th>備考</th><th>備考コピー</th><th>削除</th></tr>
	</thead>
	<tbody>

<tr class="form-block" id="form_block[0]">

<td><input type="text" name="model[0]" id="model[0]" required 
 /></td>
<td><input type="number" name="set[0]" id="set[0]" value="1" min="1" ></td>
<td><select name="unit[0]" id="unit[0]">
<option value="式" selected>式</option>
<option value="個">個</option>
<option value="枚">枚</option>
<option value="台">台</option>
<option value="セット">セット</option>
</select></td>
<td><textarea name="memo[0]" id="memo[0]"></textarea></td><td>-</td><td><!-- Closeボタン --><span class="close" title="Close" style="display: none;">削除</span></td>
</tr>

<tr class="form-block" id="form_block[1]">

<td><input type="text" name="model[1]" id="model[1]"
 /></td>
<td><input type="number" name="set[1]" id="set[1]" value="1" min="1" ></td>
<td><select name="unit[1]" id="unit[1]">
<option value="式" selected>式</option>
<option value="個">個</option>
<option value="枚">枚</option>
<option value="台">台</option>
<option value="セット">セット</option>
</select></td>
<td><textarea name="memo[1]" id="memo[1]"></textarea></td><td><button class="btn copy_clipboard" id="copy[1]" name="copy[1]">上の備考をコピー</button></td><td><!-- Closeボタン --><span class="close" title="Close" style="display: none;">削除</span></td>
</tr>

<tr class="form-block" id="form_block[2]">

<td><input type="text" name="model[2]" id="model[2]"
 /></td>
<td><input type="number" name="set[2]" id="set[2]" value="1" min="1" ></td>
<td><select name="unit[2]" id="unit[2]">
<option value="式" selected>式</option>
<option value="個">個</option>
<option value="枚">枚</option>
<option value="台">台</option>
<option value="セット">セット</option>
</select></td>
<td><textarea name="memo[2]" id="memo[2]"></textarea></td><td><button class="btn copy_clipboard" id="copy[2]" name="copy[2]">上の備考をコピー</button></td><td><!-- Closeボタン --><span class="close" title="Close" style="display: none;">削除</span></td>
</tr>

<tr class="form-block" id="form_block[3]">

<td><input type="text" name="model[3]" id="model[3]"
 /></td>
<td><input type="number" name="set[3]" id="set[3]" value="1" min="1" ></td>
<td><select name="unit[3]" id="unit[3]">
<option value="式" selected>式</option>
<option value="個">個</option>
<option value="枚">枚</option>
<option value="台">台</option>
<option value="セット">セット</option>
</select></td>
<td><textarea name="memo[3]" id="memo[3]"></textarea></td><td><button class="btn copy_clipboard" id="copy[3]" name="copy[3]">上の備考をコピー</button></td><td><!-- Closeボタン --><span class="close" title="Close" style="display: none;">削除</span></td>
</tr>

<tr class="form-block" id="form_block[4]">

<td><input type="text" name="model[4]" id="model[4]"
 /></td>
<td><input type="number" name="set[4]" id="set[4]" value="1" min="1" ></td>
<td><select name="unit[4]" id="unit[4]">
<option value="式" selected>式</option>
<option value="個">個</option>
<option value="枚">枚</option>
<option value="台">台</option>
<option value="セット">セット</option>
</select></td>
<td><textarea name="memo[4]" id="memo[4]"></textarea></td><td><button class="btn copy_clipboard" id="copy[4]" name="copy[4]">上の備考をコピー</button></td><td><!-- Closeボタン --><span class="close" title="Close" style="display: none;">削除</span></td>
</tr>

<!-- Addボタン -->
<tr>
	<td colspan="6" style="text-align:center;">
<div class="form-block" id="form_add">
<span class="add" title="Add">+</span>
</div>
	</td>
</tr>
<tr>
	<td colspan="6" style="text-align:center;">
<!--<button type="button" onclick="history.back()">戻る</button>-->
<input type="submit" value="送信" />
	</td>
</tr>
</tbody>
	</table>
</form>

</body>
</html>
