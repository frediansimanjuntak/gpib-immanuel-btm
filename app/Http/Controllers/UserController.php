<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDetail;
use App\Activity;
use App\ActivitySchedule;
use App\ActivityRegistration;
use Illuminate\Http\Request;

class UserController extends Controller
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
        return view('user');
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
        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        if (!$user_detail) {
            UserDetail::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'confirmed'=> true,
                'ref_user_id'=> $user->id,
            ]);
            $user_detail = UserDetail::where('user_id', $user->id)->first();
        }
        return view('user.profile', compact('user', 'user_detail'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);
        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $user->update($request->all());
        $user_detail->update($request->all());

        return redirect()->route('user.profile', $id)
                        ->with('success','User updated successfully');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history($id)
    {
        $user = User::find($id);
        $activity_registrations = ActivityRegistration::where('user_id', $user->id)->paginate(10);
        return view('user.history', compact('user', 'activity_registrations'))
        ->with('i', (request()->input('page', 1)-1)*10);;
    }
}
