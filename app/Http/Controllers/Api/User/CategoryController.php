<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsersInterestCategory;
use App\Models\InterestCategory;

class CategoryController extends Controller
{
    public function createUserCategory(Request $request){

        UsersInterestCategory::create([
            'user_id' => $request->user_id,
            'users_interest_category_id' => $request->category_id
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);

    }

    public function getInterestCategories(Request $request){

        return response()->json([
            'categories' => InterestCategory::all()
        ], 200);
    }
}
