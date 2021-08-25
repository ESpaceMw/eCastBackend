<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecentSearches;

class SearchController extends Controller
{
    public function create(Request $request){

        RecentSearches::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'url' => $request->url
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function get(Request $request){

        return response()->json([
            'recent_search' => RecentSearches::where('user_id', $request->user_id)->get()
        ], 200);
    }
}
