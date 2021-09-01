<?php

namespace App\Http\Controllers\Api\Podcast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PodcastEpisode;
use App\Models\PodcastSerie;

class MediaController extends Controller
{
    public function getPhotos(Request $request){

        $photos = PodcastEpisode::where('channels_id', $request->channels_id)->pluck('clip_art');

        return response()->json([
            'photos' => $photos
        ], 200);
    }

    public function getAudios(Request $request){

        $audios = PodcastEpisode::where('channels_id', $request->channels_id)->pluck('audio_file');

        return response()->json([
            'audios' => $audios
        ], 200);
    }
}
