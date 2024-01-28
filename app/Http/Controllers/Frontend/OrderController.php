<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Controller;
use Devpark\Transfers24\Exceptions\RequestExecutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Devpark\Transfers24\Requests\Transfers24;
use App\Enums\PaymentStatus;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Client;
use App\Models\CartItem;
use App\Models\Payment;

class OrderController extends Controller
{
    private Transfers24 $transfers24;

    public function __construct(Transfers24 $transfers24) {
        $this->transfers24 = $transfers24;
    }

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
        
        $order_items = $request->items;

        foreach ($order_items as $item) {
            // create order items in db
            $item = OrderItem::create([
                       'order_id' => $order->id,
                       'product_id' => $item['product_id'],
                       'quantity' => $item['quantity']
                    ]);
        }

        $user_id = (Auth::user()) ? Auth::user()->id : 0;
        $cart_items = CartItem::where('user_id', $user_id)->get();

        /*foreach( $cart_items as $cart_item ) {
            // delete cart items connected with specific user in db
            $cart_item->delete();
        }*/

        // reset session data
        //session()->flush();
        
        //return redirect('/');
        return $this->paymentTransaction($order);
    }


    public function orderCheckout()
    {
        $request = (object) [
            'cart'=> Session::get('cart'),
            'cart_items'=> Session::get('cart_items'),
        ];
        $cart = $request->cart;
        $cart_items = $request->cart_items;
        return view('frontend.checkout', compact('cart', 'cart_items'));
    }

    
    private function paymentTransaction(Order $order)
    {
        $payment = new Payment();
        $payment->order_id = $order->id;

        $this->transfers24->setEmail($order->client->email)->setAmount($order->order_total_price);
        
        try {
            $response = $this->transfers24->init();

            if($response->isSuccess()) {

                $payment->status = PaymentStatus::IN_PROGRESS;
                $payment->session_id = $response->getSessionId();
                $payment->save();

                $cart_item_controller = new CartController();
                $cart_item_controller->setCartData();

                // save registration parameters in payment object
                return redirect($this->transfers24->execute($response->getToken()));

            } else {
                $payment->status = PaymentStatus::FAIL;
                $payment->error_code = $response->getErrorCode();
                $payment->error_description = json_encode($response->getErrorDescription());
                $payment->save();
                
                $cart_item_controller = new CartController();
                $cart_item_controller->setCartData();
                
                return redirect(route('frontend.index'))->with('error', 'Something went wrong with payment.');
            }

        } catch (RequestException|RequestExecutionException $e) {
            return back()->with($e->getMessage());
        }
    }
}
