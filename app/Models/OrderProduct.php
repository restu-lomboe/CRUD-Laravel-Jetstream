<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'total'
    ];

    public function namaProduct()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
