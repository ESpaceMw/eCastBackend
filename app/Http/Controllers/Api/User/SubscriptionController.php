<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostingPlans;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function store(Request $request) {

        $this->validate($request, [
            'token' => 'required'
        ]);

        $plan = HostingPlans::where('identifier', $request->plan)
            ->orWhere('identifier', 'basic')
            ->first();

        User::find($request->user_id)->newSubscription('default', $plan->stripe_id)->create($request->token);

        return response()->json([
            'message' => 'Basic plan successfully subscribed'
        ], 200);
    }

    public function hostingPlans(Request $request){

        return response()->json([
            'hosting_plans' => HostingPlans::with('hostingPlansAttributes')->with('hostingPlanPrices')->get()
        ], 200);
    }
}
