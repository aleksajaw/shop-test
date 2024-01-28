<?php 

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;

class CartController extends Controller
{

    public function setCartData()
    {
        $current_cart_items = CartItem::availableCarts();
        $user_id = (Auth::user()) ? Auth::user()->id : 0;
        
        $structured_data = (object) [
                                    'user_id' => $user_id,
                                    'cart_items' => $current_cart_items->map(function ($cart_item) {
                                        $product = $cart_item->product;
                                        $quantity = $cart_item->quantity;
                                        $cart_item->item_total_price = $product->price * $quantity;
                                        return (object) $cart_item;
                                    }),
                                    'cart_items_amount' => count($current_cart_items),
                                    'cart_total_price' => $current_cart_items->map(function ($item) {
                                                            return $item->item_total_price;
                                                        })->sum()
                                ];
        session(['cart' => $structured_data]);
        session(['cart_items' => $structured_data->cart_items]);
        //return $structured_data; 
    }

    public function resetCartData() {
        foreach( Session::get('cart_items') as $cart_item ) {
            // delete cart items connected with specific user in db
            $cart_item->delete();
        }
        $this->setCartData();
    }

    public function viewCart()
    {
        $this->setCartData();
        $cart = Session::get('cart');
        $cart_items = $cart->cart_items;
        return view('frontend.cart', compact('cart', 'cart_items'));
    }
    
    public function getProductInCart($product_id)
    {
        return CartItem::availableCarts()->where('product_id', $product_id);
    }

    public function isProductACartItem($product_id)
    {
        return $product_id && $this->getProductInCart($product_id)->isNotEmpty();
    }

    public function addCartItem(Request $request)
    {
        $user_id = (Auth::user()) ? Auth::user()->id : 0;
        $product_id = $request->product_id;

        if ( !$this->isProductACartItem($product_id) ){
            $cart_item = CartItem::create([
                'user_id' => $user_id ? $user_id : 0,
                'product_id' => $product_id,
                'quantity' => $request->quantity,
            ]);
            $this->setCartData();

        } else {
            //$request->quantity += $item_temp->quantity;
            $this->updateCartItem($request);
        }
        return back()->withInput();
    }
    
    public function updateCartItem(Request $request)
    {   
        $request->user_id = (Auth::user()) ? Auth::user()->id : 0;

        $product_id = $request->product_id;

        $cart_item = $this->getProductInCart($product_id)->first();

        if ( $cart_item ) {
            $cart_item->quantity = $request->quantity;
            if ( !$cart_item->quantity ) {
                $this->removeCartItem($request);
                $this->setCartData();

            } else {
                $cart_item->save();
                $this->setCartData();
            }
        }
        return back()->withInput();
    }

    public function removeCartItem(Request $request)
    {
        $item = $this->getProductInCart($request->product_id)->first();
        if ( $item ) {
            $item->delete();
            $this->setCartData();
        }
        return back()->withInput();
    }
}