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
        $user = User::find($id);
        $request['email'] = $this->generate_family_email($request['name']);

        $this->validate_input_create($request);

        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $data_user = [
            'password' => Hash::make(\Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('dmY'))
        ];
        $request['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('Y-m-d');
        // Check user email and phone
        $check_user = User::where('email', $request['email'])->first();
        $check_user_details = UserDetail::where('full_name', $request['name'])->where('phone_number', $request['phone_number'])->get();
        if (isset($check_user)  && !empty($check_user)) {
            return back()->withInput()->withErrors(['Anggota keluarga anda '+$request['name']+' ini sudah terdaftar']);
        }
        else if (count($check_user_details) > 0){
            return back()->withInput()->withErrors(['Anggota keluarga anda '+$request['name']+' ini sudah terdaftar']);
        }
        else {
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

            } else {
                return back()->withInput()->withErrors(['Terjadi Kesalahan input, mohon diulangi']);
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
        $this->validate_input_edit($request);

        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $request['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('Y-m-d');

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
        $activity_registrations = ActivityRegistration::whereHas('user.user_detail',function ($query) use($user) {
            $query->where('ref_user_id', $user->id);
        })->orderBy('created_at', 'desc')->paginate(10);
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
        $user = User::find($user_id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $request['email'] = $this->generate_family_email($request['name']) ;
        $request['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('Y-m-d');

        $check_user_detail = UserDetail::where('phone_number', $request['phone_number'])->first();
        if (isset($check_user_detail) && $check_user_detail->user_id != $user_detail->user_id){
            return back()->withInput()->withErrors(['Nomor handphone ini telah digunakan']);
        }

        $this->validate_input_edit($request);


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

    private function validate_input_create($request) 
    {
        $rules = [            
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'max:12', 'unique:user_details'],
            'full_address' => 'required',
            'birth_place' => 'required',
            'birth_date' => ['required', 'date_format:d/m/Y'],
            'user_type_id' => 'required',
        ];
    
        $customMessages = [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email ini telah digunakan',
            'phone_number.max' => 'No. Handphone tidak boleh lebih dari 12 karakter',
            'phone_number.required' => 'No. Handphone tidak boleh kosong',
            'phone_number.unique' => 'No. Handphone ini telah digunakan',
            'full_address.required' => 'Alamat tidak boleh kosong',
            'birth_place.required' => 'Tempat Lahir tidak boleh kosong',
            'birth_date.required' => 'Tanggal Lahir tidak boleh kosong',
            'birth_date.date_format' => 'Format Tanggal salah harus "Tanggal/Bulan/Tahun" (31/12/1993)',
            'user_type_id.required' => 'Pilih Sektor tidak boleh kosong',
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function validate_input_edit($request) 
    {
        $rules = [            
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'max:12'],
            'full_address' => 'required',
            'birth_place' => 'required',
            'birth_date' => ['required', 'date_format:d/m/Y'],
            'user_type_id' => 'required',
        ];
    
        $customMessages = [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'phone_number.max' => 'No. Handphone tidak boleh lebih dari 12 karakter',
            'phone_number.required' => 'No. Handphone tidak boleh kosong',
            'full_address.required' => 'Alamat tidak boleh kosong',
            'birth_place.required' => 'Tempat Lahir tidak boleh kosong',
            'birth_date.required' => 'Tanggal Lahir tidak boleh kosong',
            'birth_date.date_format' => 'Format Tanggal salah harus "Tanggal/Bulan/Tahun" (31/12/1993)',
            'user_type_id.required' => 'Pilih Sektor tidak boleh kosong',
        ];

        $this->validate($request, $rules, $customMessages);
    }

    private function generate_family_email($name) 
    {
        $email_name = preg_replace('/\s*/', '', $name);
        $email_name = strtolower($email_name);
        $current_date = \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('dmY_His');
        return $email_name.'_'.$current_date.'@gpibimmanuelbtm.co';
    }
}
