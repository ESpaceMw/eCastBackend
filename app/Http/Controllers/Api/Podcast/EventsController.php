<?php

namespace App\Http\Controllers\Api\Podcast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events;
use Validator;

class EventsController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'cover_art' => 'required|file|max:3024'
        ]);

        $imageName = time().'.'.$request->cover_art->extension();
        $request->cover_art->move(public_path('storage\events'), $imageName);

        $event = Events::create([
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'content' => $request->content,
            'cover_art' => $imageName,
            'event_due' => $request->event_due
        ]);

        return response()->json([
            'message' => "Event $event->title created successfully"
        ], 200);
    }

    public function edit(Request $request){

    }

    public function promote(Request $request){

    }

    public function getEvents(Request $request){

        $events = Events::where('channel_id', $request->channel_id)->get();

        return response()->json([
            'events' => $events
        ], 200);
    }

    public function delete(Request $request){

        Events::find($request->id)->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ], 200);

    }
}
