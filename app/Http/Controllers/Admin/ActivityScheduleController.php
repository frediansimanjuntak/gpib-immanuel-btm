<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\ActivitySchedule;
use App\ActivityRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $activity = Activity::find($id);
        return view('admin.activities.schedules.create',compact('activity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);       
        $request['confirmed'] = $request['confirmed'] ? true : false;

        ActivitySchedule::create($request->all()+ ['activity_id' => $id]);

        return redirect()->route('admin.activities.edit', $id)
                        ->with('success','Activity Schedule created successfully.');
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
    public function edit($activity_id, $activity_schedule_id)
    {        
        $activity = Activity::find($activity_id);
        $activity_schedule = ActivitySchedule::where('activity_id', $activity_id)->where('id', $activity_schedule_id)->first();
        return view('admin.activities.schedules.edit',compact('activity', 'activity_schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $activity_id, $activity_schedule_id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $activity_schedule = ActivitySchedule::where('activity_id', $activity_id)->where('id', $activity_schedule_id)->first();
        $request['confirmed'] = $request['confirmed'] ? true : false;

        $activity_schedule->update($request->all()+ ['activity_id' => $activity_id]);

        return redirect()->route('admin.activities.edit', $activity_id)
                        ->with('success','Activity Schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($activity_id, $activity_schedule_id)
    {
        $activity = Activity::find($activity_id);
        $activity_schedule = ActivitySchedule::where('activity_id', $activity_id)->first();
        $activity_schedule->delete();

        return redirect()->route('admin.activities.edit', $activity_id)
                        ->with('success','Activity deleted successfully');
    }
}
