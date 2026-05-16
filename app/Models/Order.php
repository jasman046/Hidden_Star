<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'product',
        'price',
        'status',
        'qty',
        'payment_method',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
