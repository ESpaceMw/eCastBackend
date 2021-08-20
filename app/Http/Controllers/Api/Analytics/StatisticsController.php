<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StatisticsController extends Controller
{
    public function countriesListening(Request $request){

        $countries = User::all('country')[0];

        return response()->json([
           $countries
        ], 200);
    }
}
