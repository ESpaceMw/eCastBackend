<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channels;

class ChannelsController extends Controller
{
    public function getChannels(Request $request){

        return response()->json([
            'channels' => Channels::with('episodes')->with('subscribers')->get()
        ], 200);
    }
}
