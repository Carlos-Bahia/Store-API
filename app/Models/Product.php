<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_sell_price',
        'cost_price',
        'barcode',
        'weight',
        'length',
        'width',
        'height',
        'status',
        'color',
        'size',
        'material',
        'img_path'
    ];
}
