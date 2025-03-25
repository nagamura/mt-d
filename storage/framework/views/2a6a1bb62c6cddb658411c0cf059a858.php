<html>
<head>
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/supplier-confirm.css'), false); ?>">
</head>
<body>
    <div id="news">
      <div class="ttl">購買課からのお知らせ</div>
      <div class="title"><?php echo e($news->title, false); ?></div>
      <div class="body">
	<p><span style="background-color: #fbeeb8;"><strong><?php echo nl2br(e($news->body)); ?> </strong></span></p>
      </div>
    </div>
    <form action="<?php echo e(route('stock.dai3.send', [], false), false); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="wrap">
	<span class="ttl">注文番号：<input type="hidden" name="order_id" value="<?php echo e($params['order_id'], false); ?>"><?php echo e($params['order_id'], false); ?></span>
	<span>
	  <input type="hidden" name="mall_name" value="<?php echo e($params['mall_name'], false); ?>">｜モール：<?php echo e($params['mall_name'], false); ?>

	  <input type="hidden" name="mall_id" value="<?php echo e($params['mall_id'], false); ?>">｜URL：<?php echo e($params['mall_id'], false); ?>

	  <input type="hidden" name="shop_name" value="<?php echo e($params['shop_name'], false); ?>"></span>
      </div>
      <div class="wrap">
	<span class="ttl">ご注文者：</span>
	<span><input type="hidden" name="name" value="<?php echo e($params['name'], false); ?>"><?php echo e($params['name'], false); ?></span>
      </div>
      <div class="wrap">
	<span class="ttl">納品先：</span>
	<span><input type="hidden" name="address" value="<?php echo e($params['address'], false); ?>"><?php echo e($params['address'], false); ?></span>
      </div>
      <div class="wrap">
	<span class="ttl">急ぎ案件：</span>
	<span>
	  <?php if(isset($params['is_hurry'])): ?>
	  <input type="hidden" name="is_hurry" value="<?php echo e($params['is_hurry'], false); ?>">
	  急ぎ案件
	  <?php else: ?>
	  <input type="hidden" name="is_hurry" value="">
	  通常案件
	  <?php endif; ?>
	</span>
      </div>
      <div class="wrap">
	<span class="ttl">案件番号：</span>
	<span><input type="hidden" name="order_id" value="<?php echo e($params['order_id'], false); ?>"><?php echo e($params['order_id'], false); ?></span>
      </div>
      <div class="wrap">
	<span class="ttl">営業担当者：</span>
	<span>
	  <input type="hidden" name="email" value="<?php echo e($params['email'], false); ?>"><?php echo e($user->display_name, false); ?> (<?php echo e($user->code, false); ?>)
	  <input type="hidden" name="users_id" value="<?php echo e($params['users_id'], false); ?>">
	</span>
      </div>
      <p>&nbsp;</p>
      <table>
	<tr>
	  <th>型番</th>
	  <th>数量</th>
	  <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  <th><?php echo e($supplier->display_name, false); ?></th>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  <th>備考</th>
	</tr>
	<?php
	$i = 0;
	?>
	<?php $__currentLoopData = $params['item_model']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<tr>
	  <td><?php echo e($v, false); ?></td>
	  <td><?php echo e($params['item_unit'][$i], false); ?><?php echo e($params['unit_name'][$i], false); ?></td>
	  <?php
	  $j = 0;
	  ?>
	  <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <?php if(isset($params['suppliers'][$i][$j])): ?>
          <td style="text-align: center; font-weight: bold;">O<input type="hidden" name="suppliers[<?php echo e($i, false); ?>][<?php echo e($j, false); ?>]" class="sup[<?php echo e($j, false); ?>]" value="<?php echo e($supplier->id, false); ?>"></td>
  	    <?php else: ?>
	  <td style="text-align: center;"></td>
  	    <?php endif; ?>
	    <?php
	    $j++
	    ?>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  <td><?php echo e($params['memo'][$i], false); ?></td>
	</tr>
	<input type="hidden" name="ukeys[<?php echo e($i, false); ?>]" id="ukey[<?php echo e($i, false); ?>]" value="<?php echo e($params['ukeys'][$i], false); ?>" />
	<input type="hidden" name="item_model[<?php echo e($i, false); ?>]" id="model[<?php echo e($i, false); ?>]" value="<?php echo e($params['item_model'][$i], false); ?>" />
	<input type="hidden" name="base_item_model[<?php echo e($i, false); ?>]" id="origin_model[<?php echo e($i, false); ?>]" value="<?php echo e($params['base_item_model'][$i], false); ?>" />
	<input type="hidden" name="item_unit[<?php echo e($i, false); ?>]" id="set[<?php echo e($i, false); ?>]" value="<?php echo e($params['item_unit'][$i], false); ?>" />
	<input type="hidden" name="unit_name[<?php echo e($i, false); ?>]" id="unit[<?php echo e($i, false); ?>]" value="<?php echo e($params['unit_name'][$i], false); ?>" />
	<?php
	$i++
	?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<tr>
	  <td colspan="14" style="text-align:center;">
	    <button type="button" onclick="history.back()">戻る</button>
	    <input type="submit" value="送信" />
	    <div id="error"></div>
	  </td>
	</tr>
      </table>
    </form>
</body>
</html>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/stock/dai3/confirm.blade.php ENDPATH**/ ?>