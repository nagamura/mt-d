<html>
<head>
<link rel="stylesheet" href="{{ asset('/assets/css/supplier.css') }}">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="{{ asset('/assets/js/supplier.js') }}"></script>
</head>
<body>
  <div id="news">
    <div class="ttl">購買課からのお知らせ</div>
    <div class="title">{{ $news->title }}</div>
    <div class="body">
      <p><span style="background-color: #fbeeb8;"><strong>{!! nl2br(e($news->body)) !!} </strong></span></p>
    </div>
  </div>
  <form action="{{ route('stock.dai3.confirm', [], false) }}" method="post" id="form">
    @csrf
    <div>注文情報</div>
    <p>
      注文番号：<input type="hidden" name="order_id" value="{{ $params['order_id'] }}">{{ $params['order_id'] }}｜
      モール：<input type="hidden" name="mall_name" value="{{ $params['mall_name'] }}">{{ $params['mall_name'] }}｜
      URL：<input type="hidden" name="mall_id" value="{{ $params['mall_id'] }}">{{ $params['mall_id'] }}
      <input type="hidden" name="shop_name" value="{{ $params['shop_name'] }}">
    </p>
    <p>ご注文者：<input type="hidden" name="name" value="{{ $params['name'] }}">{{ $params['name'] }}</p>
    <p>納品先<span>※原則「○○県○○市」までの入力とする。</span></p>
    <p><input type="text" name="address" value="{{ $params['address'] }}" size="100"></p>
    <p><label>急ぎ案件：<input type="checkbox" name="is_hurry" value="1">急ぎ案件</label></p>
    <p>営業担当者：
      <select name="email">
	@foreach ($staffs as $staff)
	@if (Auth::id() === $staff->id)
	<option value="{{ $staff->email }}" selected="selected">{{ $staff->display_name }}({{ $staff->code }})</option>
	@else
	<option value="{{ $staff->email }}">{{ $staff->display_name }}({{ $staff->code }})</option>
	@endif
	@endforeach
      </select>
      <input type="hidden" name="users_id" value="{{ Auth::id() }}">
    </p>
    <p>&nbsp;</p>
    <button type="button" id="kaijyo">全仕入先を選択可能にする(購買課及び第3施設部専用)</button>
    <table>
      <tr>
	<th>型番</th>
	<th>数量</th>
	@php
	$i = 0;
	@endphp
	@foreach ($suppliers as $supplier)
	@if ($supplier->can_stock === App\Models\Suppliers::IS_STOCK_FALSE)
	<th>{{ $supplier->display_name }}<br><input type="checkbox" class="sup[{{ $i }}]" disabled="disabled"></th>
	@else
	<th>{{ $supplier->display_name }}<br><input type="checkbox" class="sup[{{ $i }}] allcheck"></th>
	@endif
	@php
	$i++
	@endphp
	@endforeach
	<th>備考</th>
	<th>コピー</th>
      </tr>
      @php
      $i = 0;
      @endphp
      @foreach ($orders as $order)
      <tr>
	<td>{{ $order->item_model }}</td>
	<td>{{ $order->item_unit }}式</td>
	@php
	$j = 0;
	@endphp
	@foreach ($suppliers_products[$order->item_model]['suppliers'] as $product)
	@if ($suppliers_products[$order->item_model]['count'] === 0)
	<td style="text-align: center;"><input type="checkbox" name="suppliers[{{ $i }}][{{ $j }}]" class="group{{ $i }} sup[{{ $j }}]" value="{{ $product->code }}"></td>
	@elseif ($product->is_supplier === true)
	<td style="text-align: center;"><input type="checkbox" name="suppliers[{{ $i }}][{{ $j }}]" class="group{{ $i }} sup[{{ $j }}]" value="{{ $product->code }}" checked="checked"></td>	   @else
	<td style="text-align: center;"><input type="checkbox" name="suppliers[{{ $i }}][{{ $j }}]" class="group{{ $i }} sup[{{ $j }}]" value="{{ $product->code }}" disabled="disabled"></td>
	@endif
	@php
	$j++
	@endphp
	@endforeach
	<td><textarea name="memo[{{ $i }}]" id="memo[{{ $i }}]">{{ $order->option1 }}</textarea></td>
	@if ($i === 0 || $suppliers_products[$order->item_model]['count'] === 0)
	<td>-</td>
	@elseif ($suppliers_products[$order->item_model]['count'] > 0)
	<td><button class="copy_clipboard" name="copy[{{ $i }}]" id="copy[{{ $i }}]">上の備考をコピー</button></td>
	@endif
	<input type="hidden" name="ukeys[{{ $i }}]" id="ukey[{{ $i }}]" value="{{ $order->ukey }}" />
	<input type="hidden" name="item_model[{{ $i }}]" id="model[{{ $i }}]" value="{{ $order->item_model }}" />
	<input type="hidden" name="base_item_model[{{ $i }}]" id="origin_model[{{ $i }}]" value="{{ $order->base_item_model }}" />
	<input type="hidden" name="item_unit[{{ $i }}]" id="set[{{ $i }}]" value="{{ $order->item_unit }}" />
	<input type="hidden" name="unit_name[{{ $i }}]" id="unit[{{ $i }}]" value="式" />
      </tr>
      @php
      $i++
      @endphp
      @endforeach
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
