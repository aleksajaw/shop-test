<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Client;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function finalizeOrder(Request $request)
    {   
        $request->validate([
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);
        
        $phone = $request->input('phone');
        $email = $request->input('email');

        //$similar_clients = Client::where('email', $email)->orWhere('phone', $phone)->get();

        $firstname = $request->input('firstname');
        $surname = $request->input('surname');
        $address1 = $request->input('address1');
        $address2 = $request->input('address2');

        $client = Client::create([
                    'firstname' => $firstname,
                    'surname' => $surname,
                    'address1' => $address1,
                    'address2' => $address2,
                    'email' => $email,
                    'phone' => $phone,
                ]);

        $order = Order::create([
                    'client_id' => $client->id,
                    'order_total_price' => $request->order_total_price
                ]);
        
        foreach ($request->items as $item) {
            $order_item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity']
                    ]);
        }

        $user_id = (Auth::user()) ? Auth::user()->id : 0;
        $cart_items = CartItem::where('user_id', $user_id)->get();
        foreach( $cart_items as $cart_item ) {
            $cart_item->delete();
        }

        session()->flush();
        
        return redirect('/');
    }

    public function orderCheckout()
    {
        $request = (object) [
            'cart'=> Session::get('cart'),
            'items'=> Session::get('items'),
        ];
        $cart = $request->cart;
        $items = $request->items;
        return view('frontend.checkout', compact('cart', 'items'));
    }
}
