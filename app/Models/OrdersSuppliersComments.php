<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSuppliersComments extends Model
{
    use HasFactory;

    //protected $fillable = [];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id', 'orders_id');
    }
}
