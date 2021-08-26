<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channels;
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
}
