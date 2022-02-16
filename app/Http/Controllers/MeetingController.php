<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Meeting::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        validator($request->all(), [
            'title' => 'required',
            'meeting_time' => 'required',
            'desc' => 'required'
        ])->validate();

        $meeting = new Meeting();
        $meeting->title = $request->title;
        $meeting->desc = $request->desc;
        $meeting->meeting_time = $request->meeting_time;
        $meeting->save();
        return "Meeting Saved.";
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

        $existingMeeting = Meeting::find($id);

        if($existingMeeting) {
            $existingMeeting->completed = $request->item['completed'] ? true : false;
            $existingMeeting->save();
            return $existingMeeting;
        }

        return "Meeting not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingMeeting = Meeting::find($id);

        if($existingMeeting) {
            $existingMeeting->delete();
            return "Meeting deleted";
        }

        return "Meeting not found";
    }
}
