<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersProducts extends Model
{
    use HasFactory;

    public function mProducts()
    {
        return $this->belongsTo(MProducts::class, 'm_products_id', 'id');
    }
}
