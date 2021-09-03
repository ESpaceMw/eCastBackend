<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EpisodeListens;
use DB;

class StatisticsController extends Controller
{
    public function countriesListening(Request $request){

        $countries = User::all('country')[0];

        return response()->json([
           $countries
        ], 200);
    }


    public function getListensByGender(Request $request){

        $listeners = EpisodeListens::all()->pluck('user_id');

        $males = User::find($listeners)->groupBy('gender')["M"]->count();

        $females = User::find($listeners)->groupBy('gender')["F"]->count();

        $male_listeners = round(( $males / $listeners->count() ) * 100, 2);

        $female_listeners = round(( $females / $listeners->count() ) * 100, 2);

        return response()->json([
            'male_listeners' => $male_listeners,
            'female_listeners' => $female_listeners
        ], 200);
    }

    public function getAnnualListens(Request $request){

        $listeners = EpisodeListens::groupBy('created_at', ['09'])
        ->orderBy('created_at', ['09'])
        ->get();

        return response()->json([
            'annual_listens' => $listeners
        ], 200);

    }
}
