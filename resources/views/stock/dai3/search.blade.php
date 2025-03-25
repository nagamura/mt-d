@extends('layouts.main')
@section('title', '店舗注文検索')
@section('content')
<div id="right-parent" class="p-5 lg:w-full lg:mt-0 bg-white">
  <div class="text-right fixed bottom-4 right-4" style="z-index: 100;">
    <p class="inline-block bg-white px-4 py-2 rounded-3xl" style="box-shadow: 0 2px 5px rgba(0,0,0,0.26)">
      最終更新日時は<span id="nowtime">2024/05/17 13:05:38</span>です。
      <button id="actuon">自動更新を再開</button>
    </p>
  </div>
  <form action="{{ route('stock.dai3.search', [], false) }}" method="GET">
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">セツビコム</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="sall"><input type="checkbox" id="sall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="s1"><input type="checkbox" name="shop_mall_id[0]" value="s_main_setsu-bicom" id="s1" {{ isset($params['shop_mall_id'][0]) ? 'checked="checked"' : '' }}>セツビコム 本店</label></li>
	<li class="leading-7"><label for="s2"><input type="checkbox" name="shop_mall_id[1]" value="s_main_aircon-setsubicom" id="s2" {{ isset($params['shop_mall_id'][1]) ? 'checked="checked"' : '' }}>セツビコム 別館</label></li>
	<li class="leading-7"><label for="s3"><input type="checkbox" name="shop_mall_id[2]" value="s_rakuten_setsubi" id="s3" {{ isset($params['shop_mall_id'][2]) ? 'checked="checked"' : '' }}>セツビコム 楽天市場</label></li>
	<li class="leading-7"><label for="s5"><input type="checkbox" name="shop_mall_id[3]" value="s_yahoo_setsubicom" id="s5" {{ isset($params['shop_mall_id'][3]) ? 'checked="checked"' : '' }}>セツビコム Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">イーセツビ</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="eall"><input type="checkbox" id="eall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="e1"><input type="checkbox" name="shop_mall_id[4]" value="e_main_e-setsubibiz" id="e1" {{ isset($params['shop_mall_id'][4]) ? 'checked="checked"' : '' }}>イーセツビ 本店</label></li>
	<li class="leading-7"><label for="e2"><input type="checkbox" name="shop_mall_id[5]" value="e_rakuten_e-setsubi" id="e2" {{ isset($params['shop_mall_id'][5]) ? 'checked="checked"' : '' }}>イーセツビ 楽天市場</label></li>
	<li class="leading-7"><label for="e3"><input type="checkbox" name="shop_mall_id[6]" value="e_yahoo_e-setsubi" id="e3" {{ isset($params['shop_mall_id'][6]) ? 'checked="checked"' : '' }}>イーセツビ Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="block float-left w-3/10 mr-12 mb-4">
      <div class="block font-bold mb-[5px] mt-[5px] mr-auto ml-0 border-b border-gray-800">空調センター</div>
      <ul class="m-0 p-0">
	<li class="leading-7"><span class="all-check"><label for="kall"><input type="checkbox" id="kall">全てにチェックする</label></span></li>
	<li class="leading-7"><label for="k1"><input type="checkbox" name="shop_mall_id[7]" value="k_main_tokyo-airconnet" id="k1" {{ isset($params['shop_mall_id'][7]) ? 'checked="checked"' : '' }}>空調センター 本店</label></li>
	<li class="leading-7"><label for="k2"><input type="checkbox" name="shop_mall_id[8]" value="k_rakuten_tokyo-aircon" id="k2" {{ isset($params['shop_mall_id'][8]) ? 'checked="checked"' : '' }}>空調センター 楽天市場</label></li>
	<li class="leading-7"><label for="k3"><input type="checkbox" name="shop_mall_id[9]" value="k_yahoo_tokyo-aircon" id="k3" {{ isset($params['shop_mall_id'][9]) ? 'checked="checked"' : '' }}>空調センター Yahoo!本店</label></li>
      </ul>
    </div>
    <div class="clear-both"></div>
    <div class="block w-full mb-2.5">
      <div class="block float-left w-3/10">ご注文日：<input class="border border-solid border-gray-700 p-2px w-1/4 m-5px mr-0" type="date" name="ordered_at[0]" placeholder="開始日" value="{{ isset($params['ordered_at'][0]) ? $params['ordered_at'][0]  : ''}}"> から <input class="border border-solid border-gray-700 p-2px w-1/4 m-5px mr-0" type="date" name="ordered_at[1]" placeholder="終了日" value="{{ isset($params['ordered_at']) ? $params['ordered_at'][1] : '' }}"> まで</div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="order_id" placeholder="注文ID" value="{{ isset($params['order_id']) ? $params['order_id'] : '' }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="name" placeholder="注文者名・納品先名・ヨミガナ" value="{{ $params['name'] }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="tel" name="tel" placeholder="TEL・納品先TEL" value="{{ $params['tel'] }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="email" placeholder="MAIL" value="{{ $params['email'] }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="address" placeholder="納品先住所" value="{{ $params['address'] }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="item_model" placeholder="型番" value="{{ isset($params['item_model']) ?  $params['item_model'] : '' }}"></div>
      <div class="block float-left w-3/10"><input class="border border-solid border-gray-700 py-1 px-1 mr-1 mb-2 w-9/10" type="text" name="note" placeholder="備考" value="{{ isset($params['note']) ? $params['note'] : '' }}"></div>
      <div class="block float-left w-3/10"><label for="total"><input type="checkbox" name="total" value="on" id="total">集計値を表示する</label></div>
      <div class="block float-left w-3/10">
	<input type="submit" value="絞り込む" class="text-white font-bold inline-block relative text-center shadow-sm box-border whitespace-nowrap bg-red-500 py-2 px-4 border-0 cursor-pointer font-sans opacity-100 line-height-[1.4] focus:outline-none">
	<a href="{{ route('stock.dai3.search', [], false) }}">クリアする</a>
      </div>
    </div>
  </form>
  <div style="clear:both;">&nbsp;</div>
  <div>全 {{ number_format($count) }} 件</div>
  {{ $orders->appends(request()->query())->links('vendor.pagination.shop-order') }}
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
      @foreach ($orders as $order)
      <tr class="border-b border-dotted border-white {{ App\Helpers\Helper::getBgColorFromMallId($order->mall_id) }}">
	<td class="py-[15px] px-[10px] whitespace-nowrap" rowspan="2">{{ $order->mall_id }}</td>
	<td class="py-[15px] px-[10px]" rowspan="2">{{ $order->mall_name }}</td>
	<td class="py-[15px] px-[10px]" rowspan="2">{{ $order->order_id }}</td>
	<td class="py-[15px] px-[10px]">{{ $order->progress }}</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $order->ordered_at }}</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-user" aria-hidden="true"></i>
    	  <ruby><span class="text">{{ $order->name }}</span><rt>{{ $order->name_kana }}</rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i>
    	    <div class="w-200 overflow-hidden whitespace-nowrap overflow-ellipsis"><i class="fa fa-envelope" aria-hidden="true"></i>{{ $order->email }}</div>
    	  </lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">〒{{ Helper::splitZip($order->zip) }}<br>
    	  <i class="fa fa-map-marker"></i><ruby><span class="text">{{ $order->address }}</span><rt>{{ $order->address_kana }}</rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">
    	  <i class="fa fa-phone-square" aria-hidden="true"></i>
    	  <span class="text">{{ $order->tel }}</span>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px]" rowspan="3">{{ $order->note }}</td>
      </tr>
      <tr class="border-b border-dotted border-white {{ App\Helpers\Helper::getBgColorFromMallId($order->mall_id) }}">
	<td class="py-[15px] px-[10px]"><i class="fa fa-jpy" aria-hidden="true"></i>{{ $order->payment_method }}</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $order->updated_at }}</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-user" aria-hidden="true"></i><ruby><span class="text">{{ $order->sender_name }}</span><rt>{{ $order->sender_name_kana }}</rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap">〒430-0926<br><i class="fa fa-map-marker"></i><ruby><span class="text">{{ $order->sender_address }}</span><rt>{{ $order->sender_address_kana }}</rt></ruby>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
	<td class="py-[15px] px-[10px] whitespace-nowrap"><i class="fa fa-phone-square" aria-hidden="true"></i><span class="text">{{ $order->sender_tel }}</span>
    	  <lable class="ml-5"><i class="fa fa-copy"></i></lable>
	</td>
      </tr>
      <tr class="border-b-4 border-solid border-white {{ App\Helpers\Helper::getBgColorFromMallId($order->mall_id) }}">
	<td class="py-[15px] px-[10px]"></td>
	<td class="py-[15px] px-[10px] whitespace-nowrap text-blue-600 text-[9px]">
    	  <a href="https://order-rp.rms.rakuten.co.jp/order-rb/individual-order-detail-sc/init?orderNumber={{ $order->order_id }}" target="_blank" class="block text-center leading-none">モール<br>管理画面</a>
	</td>
	<td class="py-[15px] px-[10px]"></td>
	<td class="p-0 py-[15px] px-[10px]" colspan="5">
    	  <div class="h-20 overflow-x-hidden overflow-y-scroll">
    	    <table class="w-full p-5 text-black">
	      <tbody>
		@php
		$items = $order->getItems()
		@endphp
		@if ($items->item_count > App\Consts\ShoppingMallOrders::MIN_UNIT_QTY)
		<tr>
		  <td></td>
		  <td class="text-sm text-right">合計</td>
		  <td class="text-sm text-right">{{ $order->getItems()->item_total_unit }}</td>
		  <td class="text-sm text-right">{{ number_format($order->getItems()->item_total_price) }}円</td>
		</tr>
		@endif
		@foreach ($items as $item)
		<tr>
    		  <td class="text-sm py-[15px] px-[10px]"><i class="fa fa-caret-right" aria-hidden="true"></i>{{ $item->item_name }}</td>
    		  <td class="text-sm w-100 py-[15px] px-[10px] whitespace-nowrap">{{ $item->item_model }}</td>
    		  <td class="text-sm w-50 text-right py-[15px] px-[10px] whitespace-nowrap">{{ $item->item_unit }}</td>
    		  <td class="text-sm w-100 text-regit py-[15px] px-[10px] whitespace-nowrap">{{ number_format($item->item_price) }}円</td>
    		</tr>
		@endforeach
	      </tbody>
    	    </table>
    	  </div>
	</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $orders->appends(request()->query())->links('vendor.pagination.shop-order') }}
</div>
@endsection
