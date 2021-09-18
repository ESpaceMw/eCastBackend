<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EpisodeListens;
use DB;
use App\Http\Traits\EngagementTrait;

class StatisticsController extends Controller
{
    use EngagementTrait;

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

    public function totalAnnualListens(Request $request){

        $total = EpisodeListens::whereYear('created_at', date('Y'))->get()->count();

        return response()->json([
            'total_listens' => $total
        ], 200);
    }

    public function getAnnualListens(Request $request){

        $jan = EpisodeListens::whereMonth('created_at', '01')->get()->count();
        $feb = EpisodeListens::whereMonth('created_at', '02')->get()->count();
        $mar = EpisodeListens::whereMonth('created_at', '03')->get()->count();

        $apr = EpisodeListens::whereMonth('created_at', '04')->get()->count();

        $may = EpisodeListens::whereMonth('created_at', '05')->get()->count();
        $jun = EpisodeListens::whereMonth('created_at', '06')->get()->count();
        $jul = EpisodeListens::whereMonth('created_at', '07')->get()->count();
        $aug = EpisodeListens::whereMonth('created_at', '08')->get()->count();
        $sept = EpisodeListens::whereMonth('created_at', '09')->get()->count();
        $oct = EpisodeListens::whereMonth('created_at', '10')->get()->count();
        $nov = EpisodeListens::whereMonth('created_at', '11')->get()->count();
        $dec = EpisodeListens::whereMonth('created_at', '12')->get()->count();

        return response()->json([
            $jan,
            $jan,
            $mar,
            $apr,
            $may,
            $jun,
            $jul,
            $aug,
            $sept,
            $oct,
            $nov,
            $dec
        ], 200);

    }

    public function userEngagements(Request $request)
    {
        $this->create($request->user_id);

        return response()->json([
            'message' => 'Created!'
        ], 200);
    }
}
