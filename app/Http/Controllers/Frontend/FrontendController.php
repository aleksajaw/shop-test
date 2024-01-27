<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\CartItem;
use App\Models\Client;
use App\Models\Order;

class FrontendController extends Controller
{
    public function index()
    {
        $userId = (Auth::user()) ? Auth::user()->id : 0;
        $products = Product::with('categories', 'image', 'availableCarts')->get();
        foreach($products as $product) {
            $product->currentCart = $product->availableCarts->first();
        }
        $categories = Category::all();
        return view('frontend.index', compact('products', 'categories'));
    }


    public function viewCategory($name)
    {
        if(Category::where('name', $name)->exists())
        {
            $category = Category::where('name', $name)->first();
            $products = $category->products;
            foreach($products as $product) {
                $product->currentCart = $product->availableCarts->first();
            }
        }
        $categories = Category::all();
        return view('frontend.category', compact('category', 'categories', 'products'));
    }
    

    public function viewProduct($name)
    {
        if(Product::where('name', $name)->exists())
        {
            $product = Product::where('name', $name)->with('categories', 'image')->first();
            $product->currentCart = $product->availableCarts->first();
        }
        $categories = Category::all();
        return view('frontend.product', compact( 'categories', 'product'));
    }
    
    public function viewOrders($user_id = 0)
    {
        $orders = Order::with('client', 'items')->get();
        
        return view('frontend.orders', compact( 'orders'));
    }
}