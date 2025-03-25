@extends('layouts.main')
@section('title', '在庫確認一覧')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
<link href="/assets/css/style.css?ver=1718239419" rel="stylesheet">
<link href="/assets/css/toggleSwitch.css" rel="stylesheet">
<style>
#adminFilter input[type="text"]:not(:placeholder-shown) {
  background-color: rgba(16,185,129,0.2);
}
#adminFilter input[type="date"]:not(:placeholder-shown) {
  background-color: rgba(16,185,129,0.2);
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
<script src="//unpkg.com/axios@0.26.1/dist/axios.min.js"></script>
<script src="/assets/js/idleTimer.js?ver=1718239419"></script>
<script src="{{ asset('/assets/js/stock-admin.js') }}"></script>
<script src="{{ asset('/assets/js/ajax_functions.js') }}"></script>
<div id="right-parent" class="p-5 lg:w-full lg:mt-0 bg-white">
  <div class="z-10 text-right fixed bottom-4 right-4">
    <p class="inline-block bg-white px-4 py-2 rounded-3xl" style="box-shadow: 0 2px 5px rgba(0,0,0,0.26)">最終更新日時は、2024/06/13 09:43:39 です。</p>
  </div>
  <form id="adminFilter" class="contents" action="/stock/admin.php" method="get">    
    <div class="grid lg:grid-cols-12 gap-4 gap-y-1 mb-6 grid-cols-6">
      <p class="col-span-3 lg:col-span-1 lg:row-start-1">仕入先</p>
      <button id="supplierFilter-ALL" name="supplier" class="relative col-span-1 rounded shadow p-2 cursor-pointer hover:opacity-75 lg:row-start-2 lg:col-span-1" value="ALL">ALL</button>
      @foreach ($suppliers as $supplier)
      <button id="supplierFilter-{{ $supplier->code }}" name="supplier" class="relative col-span-1 rounded shadow p-2 cursor-pointer hover:opacity-75 lg:row-start-2 lg:col-span-1" value="{{ $supplier->id }}">{{ $supplier->display_name }}</button>
      @endforeach
    </div>
    <div class="grid lg:grid-cols-8 gap-4 gap-y-1 mb-6 grid-cols-6">
      <p class="col-span-3 lg:col-span-1 lg:row-start-1">部署</p>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-2" onChange="toggleMall()" name="domainFilter" value="isAll" ><span class="ml-1 text-gray-700">全部署</span>
      </label>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-2" onChange="toggleMall()" name="domainFilter" value="2" ><span class="ml-1 text-gray-700">第2施設部</span>
      </label>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-2" onChange="toggleMall()" name="domainFilter" value="3" ><span class="ml-1 text-gray-700">第3施設部</span>
      </label>

      <fieldset class="contents" id="mallFilterItems">
        <div class="form-parts  lg:row-start-2">
          <div class="border-b border-black parts-midashi">セツビコム</div>
          <ul>
            <li><span class="all-check"><label for="S"><input onchange="allCheck(event.target)" type="checkbox" id="S" name="dai3AllChecks[]" value="setsu"  />全てにチェックする</label></span></li>
            <li><label for="s1"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_本店_setsu-bicom" id="s1"  />セツビコム 本店</label></li>
            <li><label for="s7"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_進捗_setsu-bicom" id="s7"  />セツビコム 進捗</label></li>
            <li><label for="s2"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_本店_aircon-setsubicom" id="s2"  />セツビコム 別館</label></li>
            <li><label for="s3"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_楽天_setsubi" id="s3"  />セツビコム 楽天市場</label></li>
            <li><label for="s4"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_楽天_aircon-setsubi" id="s4"  />セツビコム 楽天市場 別館</label></li>
            <li><label for="s5"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_Yahoo_setsubicom" id="s5"  />セツビコム Yahoo!本店</label></li>
            <li><label for="s6"><input type="checkbox" class="checkGroupS" name="mallFilters[]" value="s_Yahoo_aircon-setsubi" id="s6"  />セツビコム Yahoo!別館</label></li>
          </ul>
        </div>

        <div class="form-parts  lg:row-start-2">
          <div class="border-b border-black parts-midashi">イーセツビ</div>
          <ul>
            <li><span class="all-check"><label for="E"><input onchange="allCheck(event.target)" type="checkbox" id="E" name="dai3AllChecks[]" value="e-setsu" />全てにチェックする</label></span></li>
            <li><label for="e1"><input type="checkbox" class="checkGroupE" name="mallFilters[]" value="e_本店_e-setsubibiz" id="e1" />イーセツビ 本店</label></li>
            <li><label for="e5"><input type="checkbox" class="checkGroupE" name="mallFilters[]" value="e_進捗_e-setsubibiz" id="e5" />イーセツビ 進捗</label></li>
            <li><label for="e2"><input type="checkbox" class="checkGroupE" name="mallFilters[]" value="e_楽天_e-setsubi" id="e2" />イーセツビ 楽天市場</label></li>
            <li><label for="e3"><input type="checkbox" class="checkGroupE" name="mallFilters[]" value="e_Yahoo_e-setsubi" id="e3" />イーセツビ Yahoo!本店</label></li>
            <li><label for="e4"><input type="checkbox" class="checkGroupE" name="mallFilters[]" value="e_Yahoo_e-setsubi-annex" id="e4" />イーセツビ Yahoo!別館</label></li>
          </ul>
        </div>

        <div class="form-parts lg:row-start-2">
          <div class="border-b border-black parts-midashi">空調センター</div>
          <ul>
            <li><span class="all-check"><label for="K"><input onchange="allCheck(event.target)" type="checkbox" id="K" name="dai3AllChecks[]" value="kucho" />全てにチェックする</label></span></li>
            <li><label for="k1"><input type="checkbox" class="checkGroupK" name="mallFilters[]" value="k_本店_tokyo-airconnet" id="k1" />空調センター 本店</label></li>
            <li><label for="k5"><input type="checkbox" class="checkGroupK" name="mallFilters[]" value="k_進捗_tokyo-airconnet" id="k5" />空調センター 進捗</label></li>
            <li><label for="k2"><input type="checkbox" class="checkGroupK" name="mallFilters[]" value="k_楽天_tokyo-aircon" id="k2" />空調センター 楽天市場</label></li>
            <li><label for="k3"><input type="checkbox" class="checkGroupK" name="mallFilters[]" value="k_Yahoo_tokyo-aircon" id="k3" />空調センター Yahoo!本店</label></li>
            <li><label for="k4"><input type="checkbox" class="checkGroupK" name="mallFilters[]" value="k_Yahoo_tokyo-aircon-ex" id="k4" />空調センター Yahoo!別館</label></li>
          </ul>
        </div>
      </fieldset>
    </div>
    
    <div class="grid lg:grid-cols-8 gap-4 gap-y-1 mb-6 grid-cols-6">
      <p class="col-span-3 lg:col-span-2 lg:row-start-1">キーワード検索<span class="text-blue-500 cursor-pointer" onclick="resetValue('query')">クリア</span></p>
      <p class="col-span-2 lg:col-span-2 lg:row-start-1">日時(から)<span class="text-blue-500 cursor-pointer" onclick="resetValue('start')">クリア</span></p>
      <p class="col-span-2 lg:col-span-2 lg:row-start-1">日時(まで)<span class="text-blue-500 cursor-pointer" onclick="resetValue('end')">クリア</span></p>
      <input id="query" class="p-2 col-span-3 col-start-1 border rounded hover:shadow lg:col-span-2 lg:row-start-2" placeholder="キーワードを入力してください" type='text' name='query' maxlength='30' size='30' value="">
      <input id="start" class="p-2 col-span-3 border rounded hover:shadow lg:col-span-2 lg:row-start-2" type='text' name='start' value="" placeholder="日付を入力してください" onfocus="(this.type='date')">
      <input id="end" class="p-2 col-span-3 border rounded hover:shadow lg:col-span-2 lg:row-start-2" type='text' name='end' value="" placeholder="日付を入力してください" onfocus="(this.type='date')">
    </div>

    <div class="grid lg:grid-cols-8 gap-4 gap-y-1 mb-6 grid-cols-6">
      <p class="col-span-3 lg:col-span-2 lg:row-start-1">担当者<span class="text-blue-500 cursor-pointer" onclick="resetValue('person_employee_codes')">クリア</span></p>
      <p class="col-span-3 lg:col-span-2 lg:row-start-1">入力者<span class="text-blue-500 cursor-pointer" onclick="resetValue('inputter_employee_codes')">クリア</span></p>
      <input id="person_employee_codes" class="p-2 col-span-3 col-start-1 border rounded hover:shadow lg:col-span-2 lg:row-start-2" placeholder="社員番号を入力してください (カンマ区切りで複数可)" type='text' name='person_employee_codes' pattern="^\d[\d,]*\d$" maxlength='60' size='30' value="">
      <input id="inputter_employee_codes" class="p-2 col-span-3 col-start-1 border rounded hover:shadow lg:col-span-2 lg:row-start-2" placeholder="社員番号を入力してください (カンマ区切りで複数可)" type='text' name='inputter_employee_codes' pattern="^\d[\d,]*\d$" maxlength='60' size='30' value="">
    </div>

    <div class="grid lg:grid-cols-8 gap-4 gap-y-1 mb-6 grid-cols-6">
      <p class="col-span-3 lg:col-span-1 lg:row-start-1">ステータス</p>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-6" name="statusFilter" value="all" checked><span class="ml-1 text-gray-700">ALL</span>
      </label>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-6" name="statusFilter" value="1" ><span class="text-gray-700"><span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">ご確認ください</span></span>
      </label>
      <label class="p-2 col-span-2 inline-flex items-center lg:col-span-1 lg:row-start-2">
        <input type="radio" class="form-checkbox h-5 w-5 text-yellow-600 lg:row-start-6" name="statusFilter" value="0" ><span class="text-gray-700"><span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-white-100 text-black-800 border border-white-500">お待ちください</span></span>
      </label>
    </div>

    <div class="grid lg:grid-cols-8 gap-4 gap-y-1 mb-6 grid-cols-6">
      <input class="col-span-3 col-start-1 rounded shadow p-2 cursor-pointer hover:opacity-75 text-white bg-green-500 lg:row-start-1 lg:col-span-1" type='submit' value='絞り込む'>
      <p class="col-span-6 self-center">
	&#x1f447; 過去3日以内に更新があった在庫確認を表示しています。更に過去分を表示したい場合は、日時で絞り込みしてください。</p>
    </div>
  </form>
  
  <table id="fav-table" class="text-left w-full mb-12">
    <thead>
      <tr>
	<th class="sticky top-0">在確No.</th>
	<th class="sticky top-0" width="5%">日時</th>
	<th class="sticky top-0">担当者</th>
	<th class="sticky top-0">仕入先</th>
	<th class="sticky top-0" width="10%">送り先</th>
	<th class="sticky top-0" width="5%">状態</th>
	<th class="sticky top-0" width="5%">仮発注</th>
	<th class="sticky top-0">型番</th>
	<th class="sticky top-0">数量</th>
	<th class="sticky top-0" width="5%">備考</th>
	<th class="sticky top-0">入力者</th>
	<th class="sticky top-0" width="3%">在庫</th>
	<th class="sticky top-0">連絡</th>
	<th class="sticky top-0">操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($ordersList as $orderId => $orders)
      @php
      $count = count($orders);
      $i = 0;
      @endphp
      @foreach ($orders as $order)
      @if ($i === 0)
      @if ($count > App\Consts\Stock::MIN_UNIT_QTY)
      <tr role="row" class="tablesorter-hasChildRow">
      @else
      <tr role="row">
      @endif
        <td rowspan="{{ $count }}">
	  S{{ $order->id }}
	  <div>
	    <form action="{{ route('stock.admin', [], false) }}" target="_blank" method="GET">
              <input type="hidden" name="n" value="S{{ $order->id }}">
              <input type="submit" value="作成済" 
		     style="background-color: darkcyan; color: #fff; padding: 0.25rem; border-radius: 0.25rem; border: none; cursor: pointer;">
	    </form>
	  </div>
	  <div>
	    <form action="{{ route('stock.admin', [], false) }}" target="_blank" method="POST">
              <input type="hidden" name="orderId" value="{{ $order->id }}">
              <input type="submit" value="受注作成" 
		     style="background-color: #fff; color: darkcyan; padding: 0.25rem; border-radius: 0.25rem; border: 1px solid darkcyan; cursor: pointer;">
	    </form>
	  </div>
	</td>
	<td rowspan="{{ $count }}">{{ $order->created_at }}</td>
	<td rowspan="{{ $count }}">{{ $order->user_name }}({{ $order->user_code }})</td>
	<td rowspan="{{ $count }}">{{ $order->supplier_name }}</td>
	<td rowspan="{{ $count }}" id="prefCity-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}">{{ $order->sender_prefecture }}{{ $order->sender_city }}</td>
        <td rowspan="{{ $count }}">
	  @if ($order->is_hurry === App\Consts\Stock::STASUS_IS_HURRY_TRUE)
	  <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 whitespace-nowrap cursor-default">
	    &#x1f525;急ぎ
	  </span>
	  @endif
	  <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 whitespace-nowrap cursor-default" title="最後に連絡を行った日時から一定時間が経過すると、在庫確認がクローズされます。この在庫確認は、あと14日でクローズされます。">
	    &#x23f3;14日
	  </span>
	</td>
        <td rowspan="{{ $count }}">
	  <input class="preOrderCheck" type="checkbox" id="preOrderCheck-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}" disabled>
	  <label onclick="preOrderDialogComponent(event.target)" class="cursor-pointer whitespace-nowrap" for="preOrderCheck-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}" value="{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}" title="この在庫確認の商品で仮発注を行います。">仮発注</label>
	</td>
	<td>{{ $order->product_code }}</td>
	<td>{{ $order->item_unit }}式</td>
	<td>{{ Helper::normalizeOption1Text($order->option1) }}</td>
	<td>{{ $order->user_name }}({{ $order->user_code }})</td>
        <td></td>
	@if ($order->last_commented_by === '' || $order->last_commented_by === App\Consts\OrdersSuppliers::SENDER_TYPE_USER)
        <td style="background-color: rgba(255,255,255);">
	@else
        <td style="background-color: rgba(254,226,226);">
	@endif
	  @if (!$order->comments->isEmpty())
	  <ul id="posts-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}">
	    @foreach ($order->comments as $comment)
	    <li class="list-none mb-1">
	      <span class="w-80 break-words inline-block rounded px-1 border border-gray-400 mr-1">{{ $comment['content'] }}</span>
	      <span class="text-gray-400 whitespace-nowrap">{{ $comment['created_at'] }}</span>
	    </li>
	    @endforeach
	  </ul>
	  @endif
	  <div class="flex">
	    <textarea id="inputText-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}" class="px-1 border border-gray-400 rounded flex-auto" rows="1" cols="25"></textarea>
	    <button class="p-1 border border-gray-300 bg-white rounded self-end" onClick="sendPost(event.target)" value="{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}">送信</button>
	    <button class="p-1 border border-gray-300 bg-white rounded self-end" onClick="proxySendPost(event.target)" value='{ "proxyUserId": "{{ $order->supplier_id }}", "hashId": "{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}"}'>代理</button>
	  </div>
	</td>
	<td>
	  <svg id="{{ $order->id }}" value='{"orderId": "{{ $order->case_id }}", "supplier": "{{ $order->supplier_id }}", "groupId": "{{ $order->id }}"}' onclick="openToOptionDialog(event)" metadata="2" class="cursor-pointer" width="15" height="15" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	    <path class="pointer-events-none" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
	  </svg>
	</td>
      </tr>
      @else
      <tr class="tablesorter-childRow" role="row">
	<td>{{ $order->product_code }}</td>
	<td>{{ $order->item_unit }}式</td>
	<td>{{ Helper::normalizeOption1Text($order->option1) }}</td>
	<td>{{ $order->user_name }}({{ $order->user_code }})</td>
	<td></td>
	@if ($order->last_commented_by === '' || $order->last_commented_by === App\Consts\OrdersSuppliers::SENDER_TYPE_USER)
        <td style="background-color: rgba(255,255,255);">
	@else
        <td style="background-color: rgba(254,226,226);">
	@endif
	  @if (!$order->comments->isEmpty())
          <ul id="posts-{{ $order->id }}{{ $order->order_id }}{{ $order->orders_suppliers_id }}">
	    @foreach ($order->comments as $comment)
	    <li class="list-none mb-1">
	      <span class="w-80 break-words inline-block rounded px-1 border border-gray-400 mr-1">{{ $comment['content'] }}</span>
	      <span class="text-gray-400 whitespace-nowrap">{{ $comment['created_at'] }}</span>
	    </li>
	    @endforeach
          </ul>
	  @endif
          <div class="flex">
            <textarea id="inputText-{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}" class="px-1 border border-gray-400 rounded flex-auto" rows="1" cols="25"></textarea>
            <button class="p-1 border border-gray-300 bg-white rounded self-end" onclick="sendPost(event.target)" value="{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}">送信</button>
            <button class="p-1 border border-gray-300 bg-white rounded self-end" onclick="proxySendPost(event.target)" value='{ "proxyUserId": "{{ $order->supplier_id }}", "hashId": "{{ $order->id }}-{{ $order->order_id }}-{{ $order->orders_suppliers_id }}"}'>代理</button>
          </div>
	</td>
      </tr>
      @endif
      @php
      $i++;
      @endphp
    @endforeach
  @endforeach
    </tbody>
  </table>
</div>
<script type="text/javascript" src="https://services.b-aircon.jp/acc/acctag.js"></script>
@endsection
