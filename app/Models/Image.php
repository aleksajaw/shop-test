<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id','cover_image_id', );
    }
}