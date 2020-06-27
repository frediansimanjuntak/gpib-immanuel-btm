<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivitySchedule;
use App\ActivityRegistration;
use App\TicketRegistration;
use App\User;
use App\UserDetail;
use Auth;
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
        $activities = Activity::where('confirmed', true)->pluck('name', 'id');
        $activity_schedules = ActivitySchedule::where('confirmed', true)->get();
        
        $current_date = \Carbon\Carbon::now();
        $ticket_registrations = TicketRegistration::whereRaw('"'.$current_date.'" between registration_start_date and registration_end_date')->get();
        return view('user.activity_registrations.create', compact('activities', 'activity_schedules', 'ticket_registrations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_user = Auth::user();
        $current_user_detail = $current_user->user_detail;
        if (empty($current_user_detail->phone_number) || empty($current_user_detail->identity_number) || empty($current_user_detail->full_address)) {
            return redirect()->route('user.profile', $current_user->id)
                        ->withErrors(['Maaf, Mohon lengkapi data profil terlebih dahulu']);
        }
        $this->validate_input($request);

        $ticket_registration = TicketRegistration::find($request['ticket_registration_id']);
        if (!$ticket_registration) {
            return back()->withInput()->withErrors(['Pendaftaran untuk tanggal tersebut tidak dibuka']);
        } else {
            $user_ids = $request['user_ids'];
            $check_registered = ActivityRegistration::whereIn('user_id', $user_ids)
                ->where('date', $ticket_registration->date)
                ->where('cancelled', false)
                ->get();

            if (count($check_registered) > 0) {
                return back()->withInput()->withErrors(['Anggota keluarga telah mendaftar untuk ibadah dihari yang sama']);
            } else {
                if ($ticket_registration->remaining_slot() > count($user_ids)) {
                    foreach ($user_ids as $user_id) {                
                        $user_detail = User::find($user_id);
                        $user_detail_data = UserDetail::where('user_id', $user_detail->id)->first();
                        if (!$user_detail_data) {
                            UserDetail::create([
                                'user_id' => $user_detail->id,
                                'full_name' => $user_detail->name,
                                'confirmed'=> true,
                                'ref_user_id'=> $user_detail->id,
                            ]);
                        }

                        $data = [
                            'date' => $ticket_registration->date,
                            'present' => false,
                            'registration_number' => $this->generate_registration_number($request['activity_id'], $request['activity_schedule_id'], $ticket_registration->id),
                            'user_id' => $user_id
                        ];
                        ActivityRegistration::create($request->all() + $data);
                    }
                    return redirect()->route('user.history', $request['user'])
                        ->with('success','Pendaftaran Ibadah Berhasil.');
                } else {
                    return back()->withInput()->withErrors(['Maaf, Slot ibadah di gereja sudah penuh']);
                }
            }
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

    public function cancelled($id, $user_id)
    {
        $user = User::find($user_id);
        $registration = ActivityRegistration::where('id', $id)->where('user_id', $user->id)->update(['cancelled' => true]);
        return redirect()->route('user.history', $user->id)
                ->with('success','Cancel Pendaftaran Ibadah Berhasil.');
    }

    public function getActivitySchedule($activity_id)
    {
        $activity_schedules = ActivitySchedule::where('activity_id', $activity_id)->where('confirmed', true)->get();
        return $activity_schedules;
    }

    public function getTicketRegistration($activity_id, $activity_schedule_id)
    {
        $current_date = \Carbon\Carbon::now();
        $ticket_registrations = TicketRegistration::whereRaw('"'.$current_date.'" between registration_start_date and registration_end_date')->where('activity_id', $activity_id)->where('activity_schedule_id', $activity_schedule_id)->get();
        return $ticket_registrations;
    }

    private function generate_registration_number($activity_id, $activity_schedule_id, $ticket_id)
    {
        $last_activity = ActivityRegistration::where('activity_id', $activity_id)
                                                ->where('activity_schedule_id', $activity_schedule_id)
                                                ->where('ticket_registration_id', $ticket_id)
                                                ->orderBy('created_at','DESC')->first();
        $registration_number = $last_activity ? $last_activity->registration_number ? : 0 : 0;
        $current_registration_number = $registration_number + 1 ;
        return $current_registration_number; 
    }

    public function getRemainSlot($id)
    {
        $ticket = TicketRegistration::find($id);
        return $ticket->remaining_slot();
    }

    private function validate_input($request) 
    {
        $rules = [            
            'activity_id' => 'required',
            'activity_schedule_id' => 'required',
            'ticket_registration_id' => 'required',
            'user_ids' => 'required'
        ];
    
        $customMessages = [
            'activity_id.required' => 'Lokasi Ibadah tidak boleh kosong',
            'activity_schedule_id.required' => 'Jadwal Ibadah tidak boleh kosong',
            'ticket_registration_id.required' => 'Tanggal Ibadah tidak boleh kosong',
            'user_ids.required' => 'Jemaat tidak boleh kosong',
        ];

        $this->validate($request, $rules, $customMessages);
    }
}
