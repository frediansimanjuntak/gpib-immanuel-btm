<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Activity;
use App\ActivitySchedule;
use App\TicketRegistration;
use App\ActivityRegistration;
use App\Exports\ActivityRegistrationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketRegistrationController extends Controller
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
        $tickets = TicketRegistration::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'))
            ->with('i', (request()->input('page', 1)-1)*20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $activities = Activity::where('confirmed', true)->pluck('name', 'id');
        return view('admin.tickets.create', compact('activities'));
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
            'activity_schedule_id' => 'required',
            'max_participants' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required'
        ]);

        $check_registered = TicketRegistration::where('date', $request['date'])
                            ->where('activity_id', $request['activity_id'])
                            ->where('activity_schedule_id', $request['activity_schedule_id'])
                            ->get();

        if (count($check_registered) == 0) {
            TicketRegistration::create($request->all());
            return redirect()->route('admin.ticket_registrations.index')
                            ->with('success','Buka Pendaftaran Ibadah Berhasil.');
        } else {
            return back()->withInput()->withErrors(['Anda telah membuat pendaftaran ini']);;
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
        $ticket = TicketRegistration::find($id);
        $activities = Activity::where('confirmed', true)->pluck('name', 'id');
        $activity_schedules = ActivitySchedule::where('activity_id', $ticket->activity_id)->pluck('name', 'id');
        return view('admin.tickets.edit',compact('ticket', 'activities', 'activity_schedules'));
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
        $request->validate([
            'date' => 'required',
            'activity_id' => 'required',
            'activity_schedule_id' => 'required',
            'max_participants' => 'required',
            'registration_start_date' => 'required',
            'registration_end_date' => 'required'
        ]);
        $check_registered = TicketRegistration::where('date', $request['date'])
                            ->where('activity_id', $request['activity_id'])
                            ->where('activity_schedule_id', $request['activity_schedule_id'])
                            ->whereNotIn('id', [$id])
                            ->get();

        if (count($check_registered) == 0) {
            $ticket = TicketRegistration::find($id);
            if ($request['date']) {
                ActivityRegistration::where('ticket_registration_id', $ticket->id)->update(['date' => $request['date']]);
            }
            $ticket->update($request->all());
            return redirect()->route('admin.ticket_registrations.index')
                            ->with('success','Ubah Pendaftaran Ibadah Berhasil.');
        } else {
            return back()->withInput()->withErrors(['Anda telah membuat pendaftaran ini']);;
        }
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
        $activity_schedules = ActivitySchedule::where('activity_id', $activity_id)->where('confirmed', true)->get();
        return $activity_schedules;
    }

    public function export_excel($id)
    {
        $ticket = TicketRegistration::find($id);
        $activity_registration = ActivityRegistration::where('ticket_registration_id', $ticket->id)->where('cancelled', false)->get();
        
        return Excel::download(new ActivityRegistrationExport($activity_registration), '"'.$ticket->date.'"-"'.$ticket->activity->name.'"-"'.$ticket->activity_schedule->name.'"-excel.xlsx');
    }
}
