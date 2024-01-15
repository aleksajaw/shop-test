<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_and_categories', 'category_id', 'product_id', 'id', 'id');
    }
}