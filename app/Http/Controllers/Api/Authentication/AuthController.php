<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Channels;
use App\Models\BasicInfo;

use Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'city'=> $request->city,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $basicInfo = BasicInfo::create([
            'user_id' => $user->id,
            'clip_art' => 'default_clip_art.png',
            'podcast_url' => $user->first_name.$user->last_name,
            'title' => '',
            'tagline' => '',
            'description' => '',
            'category' => ''

        ]);

        $channel = Channels::create([
            'user_id' => $user->id,
            'name' => $user->first_name.$user->last_name,
            'cover_art' => 'default_cover_art.png',
            'description' => 'Hey there, this is my new podcast channel!'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                    'basic_info' => $basicInfo,
                    'channel' => $channel
        ]);

    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {

        return response()->json([
        'message' => 'These credentials do not match our records'
            ], 401);
            }

        $user = User::where('email', $request['email'])->firstOrFail();

        $channel = Channels::where('user_id', $user->id)->get();

        $basicInfo = BasicInfo::where('user_id', $user->id)->get();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'channel' => $channel,
                'basic_info' => $basicInfo
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }

    public function verify($user_id, Request $request) {

    if (!$request->hasValidSignature()) {

        return response()->json(["message" => "Invalid/Expired url provided."], 401);

    }

    $user = User::findOrFail($user_id);

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return response()->json([
        'message' => 'Verified'
    ], 200);
    }

    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }
    }

    public function update(Request $request){

        if($request->hasFile('clip_art')){

            $request->validate([
                'clip_art' => 'required|image|mimes:png,gif,jpg,jpeg|max:255'
            ]);

            $basicInfo = BasicInfo::where('user_id', $request->user_id)->firstOrFail();

            $basicInfo->clip_art = '';
            $basicInfo->title = '';
            $basicInfo->tagline = '';
            $basicInfo->description = '';
            $basicInfo->category = '';

            $basicInfo->update();
        }else{
           $basicInfo = BasicInfo::where('user_id', $request->user_id)->firstOrFail();

            $basicInfo->title = '';
            $basicInfo->tagline = '';
            $basicInfo->description = '';
            $basicInfo->category = '';

            $basicInfo->update();
        }
    }

    public function accountDeactivation(Request $request){

        $user = User::with('basic_info')
                    ->with('alerts')
                    ->with('messages')
                    ->with('channels')
                    ->with('channels.episodes')
                    ->with('channels.series')
                    ->with('channels.subscribers')
                    ->with('recentSearches')
                    ->find($request->user_id)
                    ->delete();

        return response()->json([
            'message' => 'Account deleted successfully'
        ], 200);
    }

    /*Google authentication */

    /**
     * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Email not associated with Google'
            ], 200);
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            $channel = Channels::where('user_id', $user->id)->get();

            $basicInfo = BasicInfo::where('user_id', $user->id)->get();

            $token = $existingUser->createToken('auth_token')->plainTextToken;

            return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $existingUser,
                    'channel' => $channel,
                    'basic_info' => $basicInfo
            ]);
        } else {

            $newUser                  = new User();
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->google_is;
            $newUser->save();

            $basicInfo = BasicInfo::create([
                'user_id' => $user->id,
                'clip_art' => 'default_clip_art.png',
                'podcast_url' => $newUser->name,
                'title' => '',
                'tagline' => '',
                'description' => '',
                'category' => ''

            ]);

            $channel = Channels::create([
                'user_id' => $user->id,
                'name' => $user->first_name.$user->last_name,
                'cover_art' => 'default_cover_art.png',
                'description' => 'Hey there, this is my new podcast channel!'
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'user' => $user,
                        'basic_info' => $basicInfo,
                        'channel' => $channel
            ]);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
