<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(){

    }
    public function session(){
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => 'Stripe Payment',
                    ],
                    'unit_amount' => 10000
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('stripe.cancel')."?session_id={CHECKOUT_SESSION_ID}"
        ]);
        // dd($session);
        return response()->json([
            'session' => $session,
        ]);
        return redirect($session->url);

    }
    public function success(Request $request){
        Stripe::setApiKey(config('services.stripe.secret'));
        $session_id = $request->session_id;
        if(!$session_id){
            return response()->json([
                'data' => 'Error'
            ]);
        }
        $session = Session::retrieve($session_id);
        $payment_intent =  $session->payment_intent;
        $payment = PaymentIntent::retrieve($payment_intent);
        if($payment->status === 'succeeded'){
            //database save
            //$payment->id = stripe_customer_id
            //json_encode($Payment->toArray()) = logs
        }else{

        }
    }
    public function cancel(Request $request){
        Stripe::setApiKey(config('services.stripe.secret'));
        $session_id = $request->session_id;
        if (!$session_id) {
            return response()->json([
                'data' => 'Error'
            ]);
        }
        $session = Session::retrieve($session_id);
        $payment_intent =  $session->payment_intent;
        $payment = PaymentIntent::retrieve($payment_intent);
    }
}
