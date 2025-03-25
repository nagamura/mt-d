<?php $__env->startSection('title', '店舗注文一覧'); ?>
<?php $__env->startSection('content'); ?>
<script>
$(function() {
	$('table').tablesorter();
	var count = 0;
	var action = document.getElementById('action');
	var nowtime = document.getElementById('nowtime');
	var repeatFlag = true;
	var repeat;

	function repeatFunc() {
		count += 1;
		console.log(count);
		//    repeat = setTimeout(repeatFunc, 10000000);
		repeat = setInterval('location.reload()', 60000);
	}

	//repeatFunc();

	action.onclick = function() {
		if (repeatFlag) {
			clearTimeout(repeat);
			action.innerHTML = '自動更新を再開';
			repeatFlag = false;
		} else {
			repeatFunc();
			action.innerHTML = '自動更新を停止';
			repeatFlag = true;
		}
	};

	$('#sall').on('change', function() {
		$("[id^='s']").prop('checked', this.checked);
	});

	$('#eall').on('change', function() {
		$("[id^='e']").prop('checked', this.checked);
	});

	$('#kall').on('change', function() {
		$("[id^='k']").prop('checked', this.checked);
	});
});
</script>
<script language="JavaScript">
  function mySubmit(f) {
	window.open('/stock/dai3/supplier', f.target,
		'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,width=900,height=900');
	document.input_form.target = "supp";
	document.input_form.method = "post";
	document.input_form.action = "/stock/dai3/supplier";
	document.input_form.submit();
}
</script>
<div id="right-parent" class="p-5 lg:w-full lg:mt-0 bg-white">
  <div class="text-right fixed bottom-4 right-4" style="z-index: 100;">
    <p class="inline-block bg-white px-4 py-2 rounded-3xl" style="box-shadow: 0 2px 5px rgba(0,0,0,0.26)">
      最終更新日時は<span id="nowtime">2024/05/17 13:05:38</span>です。
      <button id="action">自動更新を再開</button>
    </p>
  </div>
  <form method="GET">
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">セツビコム</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="sall"><input type="checkbox" id="sall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="s1"><input type="checkbox" name="shop_mall_id[0]" value="s_main_setsu-bicom" id="s1" <?php echo e(isset($params['shop_mall_id'][0]) ? 'checked="checked"' : '', false); ?>>セツビコム 本店</label></li>
	<li class="leading-7"><label for="s2"><input type="checkbox" name="shop_mall_id[1]" value="s_main_aircon-setsubicom" id="s2" <?php echo e(isset($params['shop_mall_id'][1]) ? 'checked="checked"' : '', false); ?>>セツビコム 別館</label></li>
	<li class="leading-7"><label for="s3"><input type="checkbox" name="shop_mall_id[2]" value="s_rakuten_setsubi" id="s3" <?php echo e(isset($params['shop_mall_id'][2]) ? 'checked="checked"' : '', false); ?>>セツビコム 楽天市場</label></li>
	<li class="leading-7"><label for="s4"><input type="checkbox" name="shop_mall_id[3]" value="s_rakuten_aircon-setsubi" id="s4" <?php echo e(isset($params['shop_mall_id'][3]) ? 'checked="checked"' : '', false); ?>>セツビコム 楽天市場 別館</label></li>
	<li class="leading-7"><label for="s5"><input type="checkbox" name="shop_mall_id[4]" value="s_yahoo_setsubicom" id="s5" <?php echo e(isset($params['shop_mall_id'][4]) ? 'checked="checked"' : '', false); ?>>セツビコム Yahoo!本店</label></li>
	<li class="leading-7"><label for="s6"><input type="checkbox" name="shop_mall_id[5]" value="s_yahoo_aircon-setsubi" id="s6" <?php echo e(isset($params['shop_mall_id'][5]) ? 'checked="checked"' : '', false); ?>>セツビコム Yahoo!別館</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">イーセツビ</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="eall"><input type="checkbox" id="eall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="e1"><input type="checkbox" name="shop_mall_id[6]" value="e_main_e-setsubibiz" id="e1" <?php echo e(isset($params['shop_mall_id'][6]) ? 'checked="checked"' : '', false); ?>>イーセツビ 本店</label></li>
	<li class="leading-7"><label for="e2"><input type="checkbox" name="shop_mall_id[7]" value="e_rakuten_e-setsubi" id="e2" <?php echo e(isset($params['shop_mall_id'][7]) ? 'checked="checked"' : '', false); ?>>イーセツビ 楽天市場</label></li>
	<li class="leading-7"><label for="e3"><input type="checkbox" name="shop_mall_id[8]" value="e_yahoo_e-setsubi" id="e3" <?php echo e(isset($params['shop_mall_id'][8]) ? 'checked="checked"' : '', false); ?>>イーセツビ Yahoo!本店</label></li>
	<li class="leading-7"><label for="e4"><input type="checkbox" name="shop_mall_id[9]" value="e_yahoo_e-setsubi-annex" id="e4" <?php echo e(isset($params['shop_mall_id'][9]) ? 'checked="checked"' : '', false); ?>>イーセツビ Yahoo!別館</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">空調センター</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="kall"><input type="checkbox" id="kall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="k1"><input type="checkbox" name="shop_mall_id[10]" value="k_main_tokyo-airconnet" id="k1" <?php echo e(isset($params['shop_mall_id'][10]) ? 'checked="checked"' : '', false); ?>>空調センター 本店</label></li>
	<li class="leading-7"><label for="k2"><input type="checkbox" name="shop_mall_id[11]" value="k_rakuten_tokyo-aircon" id="k2" <?php echo e(isset($params['shop_mall_id'][11]) ? 'checked="checked"' : '', false); ?>>空調センター 楽天市場</label></li>
	<li class="leading-7"><label for="k3"><input type="checkbox" name="shop_mall_id[12]" value="k_yahoo_tokyo-aircon" id="k3" <?php echo e(isset($params['shop_mall_id'][12]) ? 'checked="checked"' : '', false); ?>>空調センター Yahoo!本店</label></li>
	<li class="leading-7"><label for="k4"><input type="checkbox" name="shop_mall_id[13]" value="k_yahoo_tokyo-aircon-ex" id="k4" <?php echo e(isset($params['shop_mall_id'][13]) ? 'checked="checked"' : '', false); ?>>空調センター Yahoo!別館</label></li>
      </ul>
    </div>
    <div class="block w-full mb-2.5">
      <div class="block float-left w-2/3 mb-4 text-center">
	<input type="submit" value="絞り込む" class="text-white font-bold inline-block relative text-center shadow-sm box-border whitespace-nowrap bg-red-500 py-2 px-4 border-0 cursor-pointer font-sans opacity-100 line-height-[1.4] focus:outline-none">
	<a href="https://services.b-aircon.jp/stock/dai3/search.php">クリアする</a>
      </div>
    </div>
  </form>
  <div style="clear:both;">&nbsp;</div>
  <div>過去30日以内の注文データを表示しています。</div>
  <table>
    <thead>
      <tr role="row" class="tablesorter-headerRow">
	<th>
	  <div class=" whitespace-nowrap">会社名</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">モール</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">URL</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">注文番号</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">注文日時</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">注文者</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">納品先</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">型番</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">数量</div>
	</th>
	<th colspan="2">
	  <div class="whitespace-nowrap">パネル</div>
	</th>
	<th>
	  <div class="whitespace-nowrap">在庫確認</div>
	</th>
      </tr>
    </thead>
    <tbody aria-live="polite" aria-relevant="all">	
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
      $count = count($data);
      $i = 0;
      ?>
      <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($i === 0): ?>
      <form action="<?php echo e(route('stock.dai3.supplier', [], false), false); ?>" method="post" onsubmit="mySubmit(this)" target="supp">
      <?php echo csrf_field(); ?>
      <?php if($count > App\Consts\ShoppingMallOrders::MIN_UNIT_QTY): ?>
      <tr role="row" class="tablesorter-hasChildRow">
      <?php else: ?>
      <tr role="row">
      <?php endif; ?>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e(Helper::getShopName($order->shop_name), false); ?></td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->mall_name, false); ?>

	  <input type="hidden" name="mall_name" value="<?php echo e($order->mall_name, false); ?>">
	</td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->mall_id, false); ?>

	  <input type="hidden" name="mall_id" value="<?php echo e($order->mall_id, false); ?>">
	  <input type="hidden" name="shop_name" value="<?php echo e($order->shop_name, false); ?>">
	</td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->order_id, false); ?>

	  <input type="hidden" name="order_id" value="<?php echo e($order->order_id, false); ?>">
	</td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->ordered_at, false); ?></td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->name, false); ?>

	  <input type="hidden" name="name" value="<?php echo e($order->name, false); ?>">
	</td>
	<td rowspan="<?php echo e($count, false); ?>"><?php echo e($order->prefecture, false); ?> <?php echo e($order->city, false); ?>

	  <input type="hidden" name="address" value="<?php echo e($order->prefecture, false); ?><?php echo e($order->city, false); ?>">
	</td>
	<td><?php echo e($order->item_model, false); ?>

	  <input type="hidden" name="item_model[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_model, false); ?>">
	  <input type="hidden" name="base_item_model[<?php echo e($i, false); ?>]" value="<?php echo e($order->base_item_model, false); ?>">
	  <input type="hidden" name="ukeys[<?php echo e($i, false); ?>]" value="<?php echo e($order->ukey, false); ?>">
	</td>
	<td><?php echo e($order->item_unit, false); ?>

	  <input type="hidden" name="item_unit[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_unit, false); ?>">
	  <input type="hidden" name="unit_name[<?php echo e($i, false); ?>]" value="式">
	</td>
	<td><?php echo e($order->memo, false); ?>

	  <input type="hidden" name="memo[<?php echo e($i, false); ?>]" value="<?php echo e($order->memo, false); ?>">
	</td>
	<td></td>
        <td rowspan="<?php echo e($count, false); ?>">
	  <input type="submit" value="在庫確認" class="text-white font-bold inline-block relative text-center shadow-sm box-border whitespace-nowrap bg-red-500 py-2 px-4 border-0 cursor-pointer font-sans opacity-100 line-height-[1.4] focus:outline-none">
	</td>
      </tr>
      <?php else: ?>
      <tr class="tablesorter-childRow" role="row">
	<td><?php echo e($order->item_model, false); ?>

	  <input type="hidden" name="item_model[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_model, false); ?>">
	  <input type="hidden" name="base_item_model[<?php echo e($i, false); ?>]" value="<?php echo e($order->base_item_model, false); ?>">
	  <input type="hidden" name="ukeys[<?php echo e($i, false); ?>]" value="<?php echo e($order->ukey, false); ?>">
	</td>
	<td><?php echo e($order->item_unit, false); ?>

	  <input type="hidden" name="item_uni[<?php echo e($i, false); ?>]" value="<?php echo e($order->item_unit, false); ?>">
	  <input type="hidden" name="unit_name[<?php echo e($i, false); ?>]" value="式">
	</td>
	<td><?php echo e($order->memo, false); ?>

	  <input type="hidden" name="memo[<?php echo e($i, false); ?>]" value="<?php echo e($order->memo, false); ?>">
	</td>
	<td>
	</td>
      </tr>
      <?php endif; ?>
      <?php
      $i++;
      ?>
      <?php if($count === $i): ?>
      </form>
      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/stock/dai3/index.blade.php ENDPATH**/ ?>