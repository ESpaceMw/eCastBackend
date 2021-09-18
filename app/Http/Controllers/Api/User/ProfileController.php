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
        if($request->hasFile('clip_art')){
            $request->validate([
                'clip_art' => 'required|file|max:10240'
            ]);

            $imageName = time().'.'.$request->clip_art->extension();
            $request->clip_art->move(public_path('storage\profile'), $imageName);

            $basicInfo = BasicInfo::where('user_id', $request->user_id)->firstOrFail();

            $basicInfo->title = $request->title;
            $basicInfo->tagline = $request->tagline;
            $basicInfo->clip_art = $imageName;
            $basicInfo->description = $request->description;
            $basicInfo->category = $request->category;
            $basicInfo->language = $request->language;

            $basicInfo->update();

            return response()->json([
                'message' => 'Basic info updated successfully',
                'basic_info' => $basicInfo
            ], 200);
        }else{
            $basicInfo = BasicInfo::where('user_id', $request->user_id)->firstOrFail();

            $basicInfo->title = $request->title;
            $basicInfo->tagline = $request->tagline;
            $basicInfo->description = $request->description;
            $basicInfo->category = $request->category;
            $basicInfo->language = $request->language;

            $basicInfo->update();

            return response()->json([
                'message' => 'Basic info updated successfully',
                'basic_info' => $basicInfo
            ], 200);
        }
    }

    public function revert(Request $request)
    {
        return response()->json([
            'message' => 'Basic info reverted successfully'
        ], 200);
    }
}
