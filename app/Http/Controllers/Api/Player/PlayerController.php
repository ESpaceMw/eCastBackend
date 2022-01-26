<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PodcastSerie;
use App\Models\HostingPlans;
use App\Models\PodcastEpisode;

use App\Models\InterestCategory;

class PlayerController extends Controller
{
    /*Media player base api returning function */

    public function index(Request $request){


        return response()->json([

            'podcasts' => [
                'Podcasts',
                'Premium series'
            ],
            'series' => [
                PodcastSerie::all(),
                'recommended_series'
            ],
            'episodes' => PodcastEpisode::all(),

            'categories' => InterestCategory::all(),

            'hosting_plans' => HostingPlans::all(),

            'top_podcasts' => 'top_podcasts',

            'recommended' => 'recommended',

            'top_charts' => 'top_charts'
        ], 200);
    }
}
