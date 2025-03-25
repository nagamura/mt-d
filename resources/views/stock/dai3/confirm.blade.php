<html>
<head>
<link rel="stylesheet" href="{{ asset('/assets/css/supplier-confirm.css') }}">
</head>
<body>
    <div id="news">
      <div class="ttl">購買課からのお知らせ</div>
      <div class="title">{{ $news->title }}</div>
      <div class="body">
	<p><span style="background-color: #fbeeb8;"><strong>{!! nl2br(e($news->body)) !!} </strong></span></p>
      </div>
    </div>
    <form action="{{ route('stock.dai3.send', [], false) }}" method="POST">
      @csrf
      <div class="wrap">
	<span class="ttl">注文番号：<input type="hidden" name="order_id" value="{{ $params['order_id'] }}">{{ $params['order_id'] }}</span>
	<span>
	  <input type="hidden" name="mall_name" value="{{ $params['mall_name'] }}">｜モール：{{ $params['mall_name'] }}
	  <input type="hidden" name="mall_id" value="{{ $params['mall_id'] }}">｜URL：{{ $params['mall_id'] }}
	  <input type="hidden" name="shop_name" value="{{ $params['shop_name'] }}"></span>
      </div>
      <div class="wrap">
	<span class="ttl">ご注文者：</span>
	<span><input type="hidden" name="name" value="{{ $params['name'] }}">{{ $params['name'] }}</span>
      </div>
      <div class="wrap">
	<span class="ttl">納品先：</span>
	<span><input type="hidden" name="address" value="{{ $params['address'] }}">{{ $params['address'] }}</span>
      </div>
      <div class="wrap">
	<span class="ttl">急ぎ案件：</span>
	<span>
	  @isset ($params['is_hurry'])
	  <input type="hidden" name="is_hurry" value="{{ $params['is_hurry'] }}">
	  急ぎ案件
	  @else
	  <input type="hidden" name="is_hurry" value="">
	  通常案件
	  @endisset
	</span>
      </div>
      <div class="wrap">
	<span class="ttl">案件番号：</span>
	<span><input type="hidden" name="order_id" value="{{ $params['order_id'] }}">{{ $params['order_id'] }}</span>
      </div>
      <div class="wrap">
	<span class="ttl">営業担当者：</span>
	<span>
	  <input type="hidden" name="email" value="{{ $params['email'] }}">{{ $user->display_name }} ({{ $user->code }})
	  <input type="hidden" name="users_id" value="{{ $params['users_id'] }}">
	</span>
      </div>
      <p>&nbsp;</p>
      <table>
	<tr>
	  <th>型番</th>
	  <th>数量</th>
	  @foreach ($suppliers as $supplier)
	  <th>{{ $supplier->display_name }}</th>
	  @endforeach
	  <th>備考</th>
	</tr>
	@php
	$i = 0;
	@endphp
	@foreach ($params['item_model'] as $k => $v)
	<tr>
	  <td>{{ $v }}</td>
	  <td>{{ $params['item_unit'][$i] }}{{ $params['unit_name'][$i] }}</td>
	  @php
	  $j = 0;
	  @endphp
	  @foreach ($suppliers as $supplier)
	    @isset ($params['suppliers'][$i][$j])
          <td style="text-align: center; font-weight: bold;">O<input type="hidden" name="suppliers[{{ $i }}][{{ $j }}]" class="sup[{{ $j }}]" value="{{ $supplier->id }}"></td>
  	    @else
	  <td style="text-align: center;"></td>
  	    @endisset
	    @php
	    $j++
	    @endphp
	  @endforeach
	  <td>{{ $params['memo'][$i] }}</td>
	</tr>
	<input type="hidden" name="ukeys[{{ $i }}]" id="ukey[{{ $i }}]" value="{{ $params['ukeys'][$i] }}" />
	<input type="hidden" name="item_model[{{ $i }}]" id="model[{{ $i }}]" value="{{ $params['item_model'][$i] }}" />
	<input type="hidden" name="base_item_model[{{ $i }}]" id="origin_model[{{ $i }}]" value="{{ $params['base_item_model'][$i] }}" />
	<input type="hidden" name="item_unit[{{ $i }}]" id="set[{{ $i }}]" value="{{ $params['item_unit'][$i] }}" />
	<input type="hidden" name="unit_name[{{ $i }}]" id="unit[{{ $i }}]" value="{{ $params['unit_name'][$i] }}" />
	@php
	$i++
	@endphp
	@endforeach
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
