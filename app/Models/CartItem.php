<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id','product_id','quantity'];
    
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function availableCarts()
    {
        $userId = (Auth::user()) ? Auth::user()->id : 0;
        return self::where("user_id", $userId)->with('product')->get();
    }
}
