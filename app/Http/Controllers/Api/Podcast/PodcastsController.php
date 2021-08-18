<?php

namespace App\Http\Controllers\Api\Podcast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PodcastSerie;
use Image;

class PodcastsController extends Controller
{
    public function createSeries(Request $request){

        $request->validate([
            'cover_art' => 'required|file|max:3024'
        ]);

        $imageName = time().'.'.$request->cover_art->extension();
        $request->cover_art->move(public_path('storage\series'), $imageName);

        $path = public_path('storage\series');

        $img = Image::make($path.'/'.$imageName);

        $img->resize(512, 512);

        $img->save('storage\series/'.$imageName);

        PodcastSerie::create([
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'cover_art' => $imageName,
            'seasons' => $request->seasons,
            'subscription_type' => $request->subscription_type,
            'category' => $request->category,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'You have successfully created a new series'
        ], 200);
    }
}
