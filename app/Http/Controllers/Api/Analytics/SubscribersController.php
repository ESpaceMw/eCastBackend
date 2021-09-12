<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribers;
use App\Models\User;

class SubscribersController extends Controller
{
    public function subscribe(Request $request){

        if ( Subscribers::where('user_id', $request->user_id)->where('channels_id', $request->channels_id)->get()->count() >= 1) {

            return response()->json([
                'message' => "You are already subscribed to this channel"
            ], 200);

        }else{

            Subscribers::create([
                'user_id' => $request->user_id,
                'channels_id' => $request->channel_id
            ]);

            return response()->json([
                'message' => "Channel subscription successful"
            ], 200);

        }
    }

    public function unsubscribe(Request $request){

        Subscribers::where('user_id', $request->user_id)->where('channels_id', $request->channels_id)->firstOrFail()->delete();

        return response()->json([
            'message' => "Channel unsubscribed successful"
        ], 200);

    }

    public function getSubscribers(Request $request){

        $subscribersIDs = Subscribers::where('channels_id', $request->channels_id)->pluck('user_id');

        return response()->json([
            'subscribers'=> User::with('basic_info')->find($subscribersIDs)
        ], 200);

    }

    public function getNewSubscribers(Request $request){

        $subscribers = Subscribers::where('channels_id', $request->channels_id)->get()->count();

        $newSubscribers = Subscribers::where('channels_id', $request->channels_id)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->count();

        $rate = ($newSubscribers / $newSubscribers) * 100;

        return response()->json([
            'new_subscribers' => $newSubscribers,
            'rate' => $rate
        ], 200);
    }
}
