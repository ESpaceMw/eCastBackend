<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Str;
use DB;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot(ForgotPasswordRequest $request)
    {
        $email = $request->email;

        if(!User::where('email', $email)->first()){
            return response()->json([
                'message' => 'No eCast account associated with this email'
            ], 400);
        }

        $token = Str::random(10);

        DB::table('password_resets')
            ->insert(['email' => $email, 'token' => $token, 'created_at' =>  Carbon::now()]);

        $passwordReset = DB::table('password_resets')->where('token', $token)->first();

        Mail::to($email)->send(new PasswordResetMail);

        return response()->json([
            'message' => 'We have sent you a password reset link to your email',
            'token' => $passwordReset->token,
            'created_at' => $passwordReset->created_at
        ], 200);
    }

    /**
     * Show the form for resetting a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(ResetPasswordRequest $request)
    {
        $token = $request->token;

        if(!$passwordReset = DB::table('password_resets')->where('token', $token)->first()){
            return response()->json([
                'message' => 'Invalid token'
            ], 400);
        }

        if(!$user = User::where('email', $passwordReset->email)->first()){
            return response()->json([
                'message' => 'No eCast account associated with this email'
            ], 400);
        }

        $user->password = Hash::make($request->password);

        $user->update();

        return response()->json([
            'message' => 'Password reset success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
