<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->amount,
                "currency" =>$request->currency,
                "source" => $request->stripe_token,
                "description" => $request->payment_description
        ]);

        return response()->json([
            'message' => 'Payment successful!'
        ], 200);
    }
}
