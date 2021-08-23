<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use App\Models\Alerts;

class AlertController extends Controller
{
    public function create(Request $request)
    {

        $slug = Str::slug(\Carbon\Carbon::now().$request->user_id.$request->title, '-');
        Alerts::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'slug' => $slug
        ]);

        return response()->json([
            'message' => 'Alert created successfully'
        ], 200);
    }

    public function getAlerts(Request $request){

        return response()->json([
            'alerts' => Alerts::where('user_id', $request->user_id)->get()
        ], 200);
    }

    public function delete(Request $request){

        Alerts::find($request->id)->delete();

        return response()->json([
            'message' => 'Alert deleted successfully'
        ], 200);
    }
}
