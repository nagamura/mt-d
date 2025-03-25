<?php $__env->startSection('title', '店舗注文検索 | '); ?>
<?php $__env->startSection('content'); ?>
<div id="right-parent" class="p-5 lg:w-full lg:mt-0 bg-white">
  <div class="text-right fixed bottom-4 right-4" style="z-index: 100;">
    <p class="inline-block bg-white px-4 py-2 rounded-3xl" style="box-shadow: 0 2px 5px rgba(0,0,0,0.26)">
      最終更新日時は<span id="nowtime">2024/05/17 13:05:38</span>です。
      <button id="actuon">自動更新を再開</button>
    </p>
  </div>
  <form action="<?php echo e(route('stock.dai3.order.search', [], false), false); ?>" method="get">
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">セツビコム</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="sall"><input type="checkbox" id="sall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="s1"><input type="checkbox" name="shop_mall_id[]" value="s_main_setsu-bicom" id="s1">セツビコム 本店</label></li>
	<li class="leading-7"><label for="s2"><input type="checkbox" name="shop_mall_id[]" value="s_main_aircon-setsubicom" id="s2">セツビコム 別館</label></li>
	<li class="leading-7"><label for="s3"><input type="checkbox" name="shop_mall_id[]" value="s_rakuten_setsubi" id="s3">セツビコム 楽天市場</label></li>
	<li class="leading-7"><label for="s5"><input type="checkbox" name="shop_mall_id[]" value="s_yahoo_setsubicom" id="s5">セツビコム Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">イーセツビ</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="eall"><input type="checkbox" id="eall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="e1"><input type="checkbox" name="shop_mall_id[]" value="e_main_e-setsubibiz" id="e1">イーセツビ 本店</label></li>
	<li class="leading-7"><label for="e2"><input type="checkbox" name="shop_mall_id[]" value="e_rakuten_e-setsubi" id="e2">イーセツビ 楽天市場</label></li>
	<li class="leading-7"><label for="e3"><input type="checkbox" name="shop_mall_id[]" value="e_yahoo_e-setsubi" id="e3">イーセツビ Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">空調センター</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="kall"><input type="checkbox" id="kall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="k1"><input type="checkbox" name="shop_mall_id[]" value="k_main_tokyo-airconnet" id="k1">空調センター 本店</label></li>
	<li class="leading-7"><label for="k2"><input type="checkbox" name="shop_mall_id[]" value="k_rakuten_tokyo-aircon" id="k2">空調センター 楽天市場</label></li>
	<li class="leading-7"><label for="k3"><input type="checkbox" name="shop_mall_id[]" value="k_yahoo_tokyo-aircon" id="k3">空調センター Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="clear-both"></div>
    <div class="block w-full mb-2.5">
      <div class="block float-left w-3/10">ご注文日：<input class="border border-solid border-gray-700 p-2px w-1/4 m-5px mr-0" type="date" name="ordered_at[]" placeholder="開始日" value=""> から <input class="border border-solid border-gray-700 p-2px w-1/4 m-5px mr-0" type="date" name="ordered_at[]" placeholder="終了日" value=""> まで</div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="order_id" placeholder="注文ID" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="search_name" placeholder="注文者名・納品先名・ヨミガナ" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="tel" name="search_tel" placeholder="TEL・納品先TEL" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="email" placeholder="MAIL" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="search_address" placeholder="納品先住所" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="item_model" placeholder="型番" value=""></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="note" placeholder="備考" value=""></div>
      <div class="block float-left w-3/10"><label for="total"><input type="checkbox" name="total" value="on" id="total">集計値を表示する</label></div>
      <div class="block float-left w-3/10">
	<input type="submit" value="絞り込む" class="text-white font-bold inline-block relative text-center shadow-sm box-border whitespace-nowrap bg-red-500 py-2 px-4 border-0 cursor-pointer font-sans opacity-100 line-height-[1.4] focus:outline-none">
	<a href="https://services.b-aircon.jp/stock/dai3/search.php">クリアする</a>
      </div>
    </div>
  </form>
  <div style="clear:both;">&nbsp;</div>
  <div>全 <?php echo e(number_format($count), false); ?> 件</div>
  <?php echo e($orders->appends(request()->query())->links('vendor.pagination.shop-order'), false); ?>

  <table class="text-sm w-full">
    <thead class="bg-gray-800 text-white font-bold">
      <tr class="border-b border-dotted border-gray-300">
	<td rowspan="2" class="py-[15px] px-[10px] whitespace-nowrap">会社名</td>
	<td rowspan="2" class="py-[15px] px-[10px] whitespace-nowrap">店舗</td>
	<td rowspan="2" class="py-[15px] px-[10px]">注文番号</td>
	<td class="py-[15px] px-[10px]">ステータス</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">ご注文日</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><ruby>注文者名<rt>注文者カナ</rt></ruby>　<span>メール</span></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><ruby>住所<rt>住所カナ</rt></ruby></td>
	<td class="py-[15px] px-[10px]">注文者TEL</td>
	<td rowspan="3" class="py-[15px] px-[10px]">注文時コメント</td>
      </tr>
      <tr class="border-b border-dotted border-gray-300">
	<td class="py-[15px] px-[10px] whitespace-nowrap">決済方法</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">更新日時</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><ruby>納品先名<rt>納品先名カナ</rt></ruby></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><ruby>納品先住所<rt>納品先住所カナ</rt></ruby></td>
	<td class="py-[15px] px-[10px]">納品先TEL</td>
      </tr>
      <tr style="border-b-5 border-solid border-gray-500">
	<td class="py-[15px] px-[10px]"></td>
	<td class="py-[15px] px-[10px]">詳細</td>
	<td class="py-[15px] px-[10px]"></td>
	<td colspan="5" class="py-[15px] px-[10px] text-center">商品情報</td>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="border-b border-dotted border-white <?php echo e(App\Helpers\Helper::getBgColorFromMallId($order->mall_id), false); ?>">
	<td class="py-[15px] px-[10px] whitespace-nowrap" rowspan="2"><?php echo e($order->mall_id, false); ?></td>
	<td class="py-[15px] px-[10px]" rowspan="2"><?php echo e($order->mall_name, false); ?></td>
	<td class="py-[15px] px-[10px]" rowspan="2"><?php echo e($order->order_id, false); ?></td>
	<td class="py-[15px] px-[10px]"><?php echo e($order->progress, false); ?></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo e($order->ordered_at, false); ?></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-user" aria-hidden="true"></i>
    	  <ruby><span class="text"><?php echo e($order->name, false); ?></span><rt><?php echo e($order->name_kana, false); ?></rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i>
    	    <div class="w-200 overflow-hidden whitespace-nowrap overflow-ellipsis"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo e($order->email, false); ?></div>
    	  </lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">〒<?php echo e(App\Helpers\Helper::splitZip($order->zip), false); ?><br>
    	  <i class="fa fa-map-marker"></i><ruby><span class="text"><?php echo e($order->address, false); ?></span><rt><?php echo e($order->address_kana, false); ?></rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">
    	  <i class="fa fa-phone-square" aria-hidden="true"></i>
    	  <span class="text"><?php echo e($order->tel, false); ?></span>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px]" rowspan="3"><?php echo e($order->note, false); ?></td>
      </tr>
      <tr class="border-b border-dotted border-white <?php echo e(App\Helpers\Helper::getBgColorFromMallId($order->mall_id), false); ?>">
	<td class="py-[15px] px-[10px]"><i class="fa fa-jpy" aria-hidden="true"></i><?php echo e($order->payment_method, false); ?></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo e($order->updated_at, false); ?></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-user" aria-hidden="true"></i><ruby><span class="text"><?php echo e($order->sender_name, false); ?></span><rt><?php echo e($order->sender_name_kana, false); ?></rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">〒430-0926<br><i class="fa fa-map-marker"></i><ruby><span class="text"><?php echo e($order->sender_address, false); ?></span><rt><?php echo e($order->sender_address_kana, false); ?></rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-phone-square" aria-hidden="true"></i><span class="text"><?php echo e($order->sender_tel, false); ?></span>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
      </tr>
      <tr class="border-b-4 border-solid border-white <?php echo e(App\Helpers\Helper::getBgColorFromMallId($order->mall_id), false); ?>">
	<td class="py-[15px] px-[10px]"></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap text-blue-600 text-xs">
    	  <a href="https://order-rp.rms.rakuten.co.jp/order-rb/individual-order-detail-sc/init?orderNumber=<?php echo e($order->order_id, false); ?>" target="_blank" class="block text-center leading-none">モール<br>管理画面</a>
	</td>
	<td class="py-[15px] px-[10px]"></td>
	<td class="p-0 py-[15px] px-[10px]" colspan="5">
    	  <div class="h-20 overflow-x-hidden overflow-y-scroll">
    	    <table class="w-full p-5 text-black">
	      <tbody>
		<?php
		$items = $order->getItems()
		?>
		<?php if($items->item_count > App\Const\ShoppingMallOrders::MIN_UNIT_QTY): ?>
		<tr>
		  <td></td>
		  <td style="text-align: right;">合計</td>
		  <td style="text-align: right;"><?php echo e($order->getItems()->item_total_unit, false); ?></td>
		  <td style="text-align: right;"><?php echo e(number_format($order->getItems()->item_total_price), false); ?>円</td>
		</tr>
		<?php endif; ?>
		<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
    		  <td class="py-[15px] px-[10px]"><i class="fa fa-caret-right" aria-hidden="true"></i><?php echo e($item->item_name, false); ?></td>
    		  <td class="w-100 py-[15px] px-[10px] whitespace-nowrap"><?php echo e($item->item_model, false); ?></td>
    		  <td class="w-50 text-right py-[15px] px-[10px] whitespace-nowrap"><?php echo e($item->item_unit, false); ?></td>
    		  <td class="w-100 text-regit py-[15px] px-[10px] whitespace-nowrap"><?php echo e(number_format($item->item_price), false); ?>円</td>
    		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      </tbody>
    	    </table>
    	  </div>
	</td>
      </tr>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
  <?php echo e($orders->appends(request()->query())->links('vendor.pagination.shop-order'), false); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/stock/dai3/order.blade.php ENDPATH**/ ?>