<html>
<head>
  <link rel="stylesheet" href="<?php echo e(asset('/assets/css/supplier-send.css'), false); ?>">
</head>
<body>
  <div>在庫確認を送信しました。</div>
  <div style="color:#FF0000;line-height: 200%;">【失敗】注文番号「'.$order_id."」での「".$model."」の仕入先CD「".$sup."」への在庫確認は既に在庫確認登録済です。</div>
  <div style="color:#000000;line-height: 200%;">【成功】注文番号「'.$order_id."」での「".$model."」の仕入先CD「".$sup."」への在庫確認は正しく登録できました。</div>
  <div>
    <input type="button" value="閉じる" onclick="window.opener.location.reload(); window.close();">
  </div>
</body>
</html>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/stock/dai3/send.blade.php ENDPATH**/ ?>