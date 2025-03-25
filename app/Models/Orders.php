<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    const STATUS_STOCK_IN_CONFIRM = 1;
    
    use HasFactory;
    
    protected $table = 'orders';
    protected $fillable = [
        '_token',
        'users_id',
        'mall_id',
        'order_id',
        'case_id',
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
        'sender_name',
        'sender_name_kana',
        'sender_zip',
        'sender_prefecture',
        'sender_city',
        'sender_sub_address',
        'sender_address',
        'sender_address_kana',
        'sender_tel',
        'payment_code',
        'payment_method',
        'is_hurry',
        'is_order_status',
        'closed_at',
        'ordered_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(Users::class, 'id', 'users_id');
    }

    public function orderSupplier(): HasMany
    {
        return $this->hasMany(OrdersSuppliers::class, 'orders_id', 'id');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(OrdersSuppliers::class, 'orders_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(OrdersSuppliersComments::class, 'orders_id', 'id');
    }
}
