<?php

namespace App\Http\Controllers\Api\Overview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Auth;

class InboxController extends Controller
{
    public function fetchMessages(Request $request)
    {
        return response()->json([
           'messages' => Message::with('user')->where('sender_id', $request->sender_id)->get()
        ], 200);
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = Message::create([
            'message' => $request->message,
            'sender_id' => $request->sender_id,
            'rec_id' => $request->rec_id
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return response()->json(['status' => 'Message Sent!'], 200);
    }
}
