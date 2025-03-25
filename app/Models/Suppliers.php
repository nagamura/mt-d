<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suppliers extends Model
{
    use HasFactory;
    const IS_STOCK_FALSE = 0;
    const IS_HURRY_TRUE = 1;

    public function orders(): HasMany
    {
        return $this->hasMany(OrdersSuppliers::class, 'suppliers_id', 'id');
    }
}
