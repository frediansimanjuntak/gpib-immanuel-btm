<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDetail;
use App\Activity;
use App\ActivitySchedule;
use App\ActivityRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    public function create($id)
    {        
        return view('user.create');
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
            'name' => 'required'
        ]);
        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $email_name = preg_replace('/\s*/', '', $request['name']);
        $email_name = strtolower($email_name);

        $request['email'] = $request['email'] ? : $email_name.'@gpibimmanuelbtm.co';
        $data_user = [
            'password' => Hash::make(\Carbon\Carbon::parse($request['birth_date'])->format('dmY'))
        ];
        $user_created = User::create($request->all() + $data_user);
        if ($user_created) {
            $data_user_detail = [
                'full_name' => $user_created->name,
                'ref_user_id' => $user->id,
                'user_id' => $user_created->id,
                'confirmed' => true
            ];
            UserDetail::create($request->all() + $data_user_detail);
            return redirect()->route('user.profile', $id)
                            ->with('success','Tambah Keluarga successfully');

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

        $family = UserDetail::where('ref_user_id', $user->id)->whereNotIn('user_id', [$user->id])->paginate(10);
        return view('user.profile', compact('user', 'user_detail', 'family'))
        ->with('i', (request()->input('page', 1)-1)*10);
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

        $data_user_details = [
            'full_name' => $request['name'],
        ];
        $user->update($request->all());
        $user_detail->update($request->all() + $data_user_details);

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
        $activity_registrations = ActivityRegistration::orderByDesc('created_at')->paginate(10);
        return view('user.history', compact('user', 'activity_registrations'))
        ->with('i', (request()->input('page', 1)-1)*10);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_family($ref_user_id, $user_id)
    {
        $user = User::find($user_id);
        return view('user.edit-family', compact('user'));
    }

    public function update_family(Request $request, $ref_user_id, $user_id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user = User::find($user_id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();

        $data_user_details = [
            'full_name' => $request['name'],
        ];
        $user->update($request->all());
        $user_detail->update($request->all() + $data_user_details);

        return redirect()->route('user.profile', $ref_user_id)
                        ->with('success','User updated successfully');
    }

    public function destroy_family($ref_user_id, $user_id)
    {
        $user = User::find($user_id);
        $user_detail = UserDetail::where('user_id', $user->id)->where('ref_user_id', $ref_user_id)->first();
        $registeredActivity = ActivityRegistration::where('user_id', $user->id)->get();
        if($registeredActivity) $registeredActivity->each->delete();
        if($user_detail) $user_detail->delete();
        $user->delete();

        return redirect()->route('user.profile', $ref_user_id)
                        ->with('success','User deleted successfully');        
    }
}
