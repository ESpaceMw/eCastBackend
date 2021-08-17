<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribers;

class SubscribersController extends Controller
{
    public function subscribe(Request $request){

        if ( Subscribers::where('user_id', $request->user_id)->where('channel_id', $request->channel_id)->get()->count() >= 1) {

            return response()->json([
                'message' => "You are already subscribed to this channel"
            ], 200);

        }else{

            Subscribers::create([
                'user_id' => $request->user_id,
                'channel_id' => $request->channel_id
            ]);

            return response()->json([
                'message' => "Channel subscription successful"
            ], 200);

        }
    }

    public function unsubscribe(Request $request){

        Subscribers::where('user_id', $request->user_id)->where('channel_id', $request->channel_id)->firstOrFail()->delete();

        return response()->json([
            'message' => "Channel unsubscribed successful"
        ], 200);

    }

    public function getSubscribers(Request $request){

        $subscribersIDs = Subscribers::where('channel_id', $request->channel_id)->pluck('user_id');

        return response()->json([
            'subscribers'=> $subscribersIDs
        ], 200);

    }
}
