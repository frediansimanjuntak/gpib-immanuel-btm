<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivitySchedule;
use App\ActivityRegistration;
use Illuminate\Http\Request;

class ActivityRegistrationController extends Controller
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
    public function create()
    {
        $activities = Activity::pluck('name', 'id');
        $activity_schedules = ActivitySchedule::all();
        return view('user.activity_registrations.create', compact('activities', 'activity_schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'activity_id' => 'required',
            'activity_schedule_id' => 'required'
        ]);

        $data = [
            'present' => false,
            'registration_number' => 0
        ];

        $check_registered = ActivityRegistration::where('user_id', $request['user_id'])
                            ->where('date', $request['date'])
                            ->where('activity_id', $request['activity_id'])
                            ->where('activity_schedule_id', $request['activity_schedule_id'])
                            ->get();

        if (count($check_registered) == 0) {
            ActivityRegistration::create($request->all() + $data);
            return redirect()->route('home')
                            ->with('success','Activity Registration created successfully.');
        } else {
            return back()->withInput()->withErrors(['Anda telah mendaftar untuk ibadah ini']);;
        }
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

    public function getActivitySchedule($activity_id)
    {
        $activity_schedules = ActivitySchedule::where('activity_id', $activity_id)->get();
        return $activity_schedules;
    }
}
