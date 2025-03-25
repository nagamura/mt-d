<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSuppliers extends Model
{
    const STATUS_STOCK_IN_CONFIRM = 1;
        
    use HasFactory;
    
    protected $fillable = [
        'orders_id',
        'suppliers_id',
        'm_products_id',
        'ukey',
        'item_price',
        'item_unit',
        'option1',
        'option2',
        'note',
        'discount_amount',
        'is_stock_confirm',
        'is_stock',
        'is_order_status',
        'is_close',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'orders_id');
    }

    public function supplier()
    {
        return $this->hasOne(Suppliers::class, 'id', 'suppliers_id');
    }

    public function product()
    {
        return $this->hasOne(M_Products::class, 'id', 'm_products_id');
    }
}
