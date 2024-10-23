<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{
    protected $table = 'category_x_product';

    protected $fillable = [
        'category_id',
        'product_id',
    ];
}
