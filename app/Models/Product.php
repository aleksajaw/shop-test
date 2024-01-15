<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'cover_image_id', 'description', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_and_categories', 'product_id', 'category_id', 'id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'cover_image_id', 'id');
    }

    public function availableCarts()
    {
        $userId = (Auth::user()) ? Auth::user()->id : 0;
        return $this->hasMany(CartItem::class, 'product_id', 'id')->where('user_id', $userId);
    }
}