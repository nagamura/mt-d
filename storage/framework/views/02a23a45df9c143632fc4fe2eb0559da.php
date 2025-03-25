<html>
<head>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/supplier.css'), false); ?>">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="<?php echo e(asset('/assets/js/supplier.js'), false); ?>"></script>
</head>
<body>
  <div id="news">
    <div class="ttl">購買課からのお知らせ</div>
    <div class="title"><?php echo e($news->title, false); ?></div>
    <div class="body">
      <p><span style="background-color: #fbeeb8;"><strong><?php echo nl2br(e($news->body)); ?> </strong></span></p>
    </div>
  </div>
  <form action="<?php echo e(route('stock.dai3.confirm', [], false), false); ?>" method="post" id="form">
    <?php echo csrf_field(); ?>
    <div>注文情報</div>
    <p>
      注文番号：<input type="hidden" name="order_id" value="<?php echo e($params['order_id'], false); ?>"><?php echo e($params['order_id'], false); ?>｜
      モール：<input type="hidden" name="mall_name" value="<?php echo e($params['mall_name'], false); ?>"><?php echo e($params['mall_name'], false); ?>｜
      URL：<input type="hidden" name="mall_id" value="<?php echo e($params['mall_id'], false); ?>"><?php echo e($params['mall_id'], false); ?>

      <input type="hidden" name="shop_name" value="<?php echo e($params['shop_name'], false); ?>">
    </p>
    <p>ご注文者：<input type="hidden" name="name" value="<?php echo e($params['name'], false); ?>"><?php echo e($params['name'], false); ?></p>
    <p>納品先<span>※原則「○○県○○市」までの入力とする。</span></p>
    <p><input type="text" name="address" value="<?php echo e($params['address'], false); ?>" size="100"></p>
    <p><label>急ぎ案件：<input type="checkbox" name="is_hurry" value="1">急ぎ案件</label></p>
    <p>営業担当者：
      <select name="email">
	<?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if(Auth::id() === $staff->id): ?>
	<option value="<?php echo e($staff->email, false); ?>" selected="selected"><?php echo e($staff->display_name, false); ?>(<?php echo e($staff->code, false); ?>)</option>
	<?php else: ?>
	<option value="<?php echo e($staff->email, false); ?>"><?php echo e($staff->display_name, false); ?>(<?php echo e($staff->code, false); ?>)</option>
	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <input type="hidden" name="users_id" value="<?php echo e(Auth::id(), false); ?>">
    </p>
    <p>&nbsp;</p>
    <button type="button" id="kaijyo">全仕入先を選択可能にする(購買課及び第3施設部専用)</button>
    <table>
      <tr>
	<th>型番</th>
	<th>数量</th>
	<?php
	$i = 0;
	?>
	<?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($supplier->can_stock === App\Models\Suppliers::IS_STOCK_FALSE): ?>
	<th><?php echo e($supplier->display_name, false); ?><br><input type="checkbox" class="sup[<?php echo e($i, false); ?>]" disabled="disabled"></th>
	<?php else: ?>
	<th><?php echo e($supplier->display_name, false); ?><br><input type="checkbox" class="sup[<?php echo e($i, false); ?>] allcheck"></th>
	<?php endif; ?>
	<?php
	$i++
	?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<th>備考</th>
	<th>コピー</th>
      </tr>
      <?php
      $i = 0;
      ?>
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
	<td><?php echo e($order->item_model, false); ?></td>
	<td><?php echo e($order->item_unit, false); ?>式</td>
	<?php
	$j = 0;
	?>
	<?php $__currentLoopData = $suppliers_products[$order->item_model]['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($suppliers_products[$order->item_model]['count'] === 0): ?>
	<td style="text-align: center;"><input type="checkbox" name="suppliers[<?php echo e($i, false); ?>][<?php echo e($j, false); ?>]" class="group<?php echo e($i, false); ?> sup[<?php echo e($j, false); ?>]" value="<?php echo e($product->code, false); ?>"></td>
	<?php elseif($product->is_supplier === true): ?>
	<td style="text-align: center;"><input type="checkbox" name="suppliers[<?php echo e($i, false); ?>][<?php echo e($j, false); ?>]" class="group<?php echo e($i, false); ?> sup[<?php echo e($j, false); ?>]" value="<?php echo e($product->code, false); ?>" checked="checked"></td>	   <?php else: ?>
	<td style="text-align: center;"><input type="checkbox" name="suppliers[<?php echo e($i, false); ?>][<?php echo e($j, false); ?>]" class="group<?php echo e($i, false); ?> sup[<?php echo e($j, false); ?>]" value="<?php echo e($product->code, false); ?>" disabled="disabled"></td>
	<?php endif; ?>
	<?php
	$j++
	?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<td><textarea name="memo[<?php echo e($i, false); ?>]" id="memo[<?php echo e($i, false); ?>]"><?php echo e($order->option1, false); ?></textarea></td>
	<?php if($i === 0 || $suppliers_products[$order->item_model]['count'] === 0): ?>
	<td>-</td>
	<?php elseif($suppliers_products[$order->item_model]['count'] > 0): ?>
	<td><button class="copy_clipboard" name="copy[<?php echo e($i, false); ?>]" id="copy[<?php echo e($i, false); ?>]">上の備考をコピー</button></td>
	<?php endif; ?>
	<input type="hidden" name="ukeys[<?php echo e($i, false); ?>]" id="ukey[<?php echo e($i, false); ?>]" value="<?php echo e($order->ukey, false); ?>" />
	<input type="hidden" name="item_model[<?php echo e($i, false); ?>]" id="model[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_model, false); ?>" />
	<input type="hidden" name="base_item_model[<?php echo e($i, false); ?>]" id="origin_model[<?php echo e($i, false); ?>]" value="<?php echo e($order->base_item_model, false); ?>" />
	<input type="hidden" name="item_unit[<?php echo e($i, false); ?>]" id="set[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_unit, false); ?>" />
	<input type="hidden" name="unit_name[<?php echo e($i, false); ?>]" id="unit[<?php echo e($i, false); ?>]" value="式" />
      </tr>
      <?php
      $i++
      ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <tr>
	<td colspan="14" style="text-align:center;">&nbsp;</td>
      </tr>
      <tr>
	<td colspan="14" style="text-align:center;">
          <input type="button" value="閉じる" onclick="window.opener.location.reload(); window.close();">
          <input type="submit" value="送信">
          <div id="error"></div>
	</td>
      </tr>
    </table>
  </form>
</body>
</html>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/stock/dai3/supplier.blade.php ENDPATH**/ ?>