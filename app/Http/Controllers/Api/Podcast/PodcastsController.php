<?php

namespace App\Http\Controllers\Api\Podcast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PodcastSerie;
use Image;
use App\Models\PodcastEpisode;

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

    public function deleteSeries(Request $request){

        PodcastSerie::find($request->id)->delete();

        return response()->json([
            'message' => 'Serie deleted successfully!'
        ], 200);
    }

    public function createEpisode(Request $request){

        $request->validate([

            'audio_file' => 'required|file|max:10240',
            'clip_art' => 'required|file|max:10240'

        ]);


        $audioFile = time().'.'.$request->audio_file->extension();
        $request->audio_file->move(public_path('storage\podcasts'), $audioFile);

        $imageName = time().'.'.$request->clip_art->extension();
        $request->clip_art->move(public_path('storage\podcasts'), $imageName);

        $path = public_path('storage\podcasts');

        $img = Image::make($path.'/'.$imageName);

        $img->resize(512, 512);

        $img->save('storage\podcasts/'.$imageName);

        PodcastEpisode::create([
            'podcast_series_id' => $request->serie_id,
            'title' => $request->title,
            'season' => $request->season,
            'episode_number' => $request->ePNumber,
            'audio_file' => $audioFile,
            'clip_art' => $imageName,
            'description' => $request->description,
            'privacy' => $request->privacy,
            'uploaded_at' => $request->uploadedAt
        ]);

        return response()->json([
            'message' => 'Episode created successfully!'
        ], 200);
    }
}
