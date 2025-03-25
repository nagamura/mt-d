<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingMallOrders extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'mall_id',
        'order_id',
        'ukey',
        'shop_mall_id',
        'shop_name',
        'mall_name',
        'name',
        'name_kana',
        'zip',
        'prefecture',
        'city',
        'sub_address',
        'address',
        'address_kana',
        'progress',
        'tel',
        'email',
        'option1',
        'option2',
        'sender_name',
        'sender_name_kana',
        'sender_zip',
        'sender_prefecture',
        'sender_city',
        'sender_sub_address',
        'sender_address',
        'sender_address_kana',
        'sender_tel',
        'item_name',
        'item_model',
        'item_price',
        'item_unit',
        'payment_code',
        'payment_method',
        'is_stock_confirm',
        'note',
        'discount_amount',
        'ordered_at',
    ];

    const IS_STOCK_CONFIRM_TRUE = 9; //在庫確認提出済
    const IS_STOCK_CONFIRM_FALSE = 0;//在庫確認未提出
    const EXCLUDE_ITEM_MODEL = [
        '-',
        'お時間指定料',
        '時間指定料',
        '時間指定',
        '車種ご指定料（ゲート車）',
        '部材',
        '木台',
    ];

    public function getItems()
    {
        $items = ShoppingMallOrders::select('item_name', 'item_model', 'item_price', 'item_unit')
               ->where('order_id', $this->order_id)
               ->get();
        
        $count = 1;
        $items->item_total_unit = 0;
        $items->item_total_price = 0;
        foreach ($items as $item) {
            $items->item_count = $count++;
            $items->item_total_unit += $item->item_unit;
            $items->item_total_price += ($item->item_price * $item->item_unit);
        }
        
        return $items;
    }
}
