<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BasicInfo;
use Image;

class ProfileController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'clip_art' => 'required|file|max:3024'
        ]);

        $imageName = time().'.'.$request->clip_art->extension();
        $request->clip_art->move(public_path('storage\profile'), $imageName);

        $path = public_path('storage\profile');

        $img = Image::make($path.'/'.$imageName);

        $img->resize(512, 512);

        $img->save('storage\profile/'.$imageName);

        BasicInfo::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'tagline' => $request->tagline,
            'clip_art' => $imageName,
            'description' => $request->description,
            'category' => $request->category,
            'language' => $request->language
        ]);

        return response()->json([
            'message' => 'Basic info created successfully'
        ], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'clip_art' => 'required|file|max:3024'
        ]);

        $imageName = time().'.'.$request->clip_art->extension();
        $request->clip_art->move(public_path('storage\profile'), $imageName);

        $path = public_path('storage\profile');

        $img = Image::make($path.'/'.$imageName);

        $img->resize(512, 512);

        $img->save('storage\profile/'.$imageName);

        BasicInfo::update([
            'title' => $request->title,
            'tagline' => $request->tagline,
            'clip_art' => $request->clip_art,
            'description' => $request->description,
            'category' => $request->category,
            'language' => $request->language
        ]);

        return response()->json([
            'message' => 'Basic info updated successfully'
        ], 200);
    }

    public function revert(Request $request)
    {
        return response()->json([
            'message' => 'Basic info reverted successfully'
        ], 200);
    }
}
