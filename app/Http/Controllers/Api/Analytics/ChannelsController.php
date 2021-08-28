<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channels;
use App\Models\ListenersReviews;
use Validator;

class ChannelsController extends Controller
{
    public function updateChannel(Request $request){

        if($request->hasFile('cover_art')){

            $validator = Validator::make($request->all(),[

                'cover_art' => 'required|mimes:png,jpg,jpeg,gif|max:10240'

            ]);

            $imageName = time().'.'.$request->cover_art->extension();
            $request->cover_art->move(public_path('storage\profile'), $imageName);

            $channel = Channels::where('user_id', $request->user_id)->firstOrFail();

            $channel->name = $request->name;
            $channel->description = $request->description;
            $channel->cover_art = $imageName;

            $channel->update();

            return response()->json([
                'message' => 'Channel edited successfully'
            ], 200);


        }else{

            $channel = Channels::where('user_id', $request->user_id)->firstOrFail();

            $channel->name = $request->name;
            $channel->description = $request->description;

            $channel->update();

            return response()->json([
                'message' => 'Channel edited successfully'
            ], 200);
        }
    }
    public function getChannels(Request $request){

        return response()->json([
            'channels' => Channels::with('episodes')->with('subscribers')->get()
        ], 200);
    }

    public function createReview(Request $request){

        $review = ListenersReviews::create([
            'channels_id' => $request->channels_id,
            'reviewer_name' => $request->name,
            'reviewer_avatar' => $request->avatar,
            'review' => $request->review,
            'stars' => $request->stars
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function getReviews(Request $request){

        return response()->json([
            'reviews'  => ListenersReviews::where('channels_id', $request->channels_id)->get()
        ], 200);
    }

    public function channelProfile(Request $request){

        $user = User::with('channels')->with('channels.podcast_episodes')->get();

        return response()->json([
            'user' => $user
        ], 200);
    }

}
