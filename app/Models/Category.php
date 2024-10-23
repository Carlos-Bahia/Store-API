<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'img_path'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->using(CategoryProduct::class)
                    ->withTimestamps();
    }
}