<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDetail;
use App\UserType;
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
        $user_types = UserType::where('confirmed', true)->pluck('name', 'id');
        return view('user.create', compact('user_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $email_name = preg_replace('/\s*/', '', $request['name']);
        $email_name = strtolower($email_name);
        $request['email'] = $request['email'] ? : $email_name.'@gpibimmanuelbtm.co';

        $this->validate_input($request);

        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
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
                            ->with('success','Tambah Keluarga Berhasil');

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
        $user_types = UserType::where('confirmed', true)->pluck('name', 'id');
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
        return view('user.profile', compact('user', 'user_detail', 'family', 'user_types'))
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
        $this->validate_input($request);

        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();

        $data_user_details = [
            'full_name' => $request['name'],
        ];
        $user->update($request->all());
        $user_detail->update($request->all() + $data_user_details);

        return redirect()->route('user.profile', $id)
                        ->with('success','Ubah data profil berhasil');
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
        $user_types = UserType::where('confirmed', true)->pluck('name', 'id');
        return view('user.edit-family', compact('user', 'user_types'));
    }

    public function update_family(Request $request, $ref_user_id, $user_id)
    {
        $this->validate_input($request);

        $user = User::find($user_id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();

        $data_user_details = [
            'full_name' => $request['name'],
        ];
        $user->update($request->all());
        $user_detail->update($request->all() + $data_user_details);

        return redirect()->route('user.profile', $ref_user_id)
                        ->with('success','Ubah data keluarga berhasil');
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
                        ->with('success','Hapus data keluarga berhasil');        
    }

    private function validate_input($request) 
    {
        $rules = [            
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'full_address' => 'required',
            'identity_type' => 'required',
            'identity_number' => 'required',
            'family_card_number' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'user_type_id' => 'required',
        ];
    
        $customMessages = [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'phone_number.required' => 'No. Handphone tidak boleh kosong',
            'full_address.required' => 'Alamat tidak boleh kosong',
            'identity_type.required' => 'Tipe Identitas tidak boleh kosong',
            'identity_number.required' => 'Nomor Identitas tidak boleh kosong',
            'family_card_number.required' => 'Nomor Kartu Keluarga tidak boleh kosong',
            'birth_place.required' => 'Tempat Lahir tidak boleh kosong',
            'birth_date.required' => 'Tanggal Lahir tidak boleh kosong',
            'user_type_id.required' => 'Pilih Sektor tidak boleh kosong',
        ];

        $this->validate($request, $rules, $customMessages);
    }
}
