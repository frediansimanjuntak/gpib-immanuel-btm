<?php

namespace App\Http\Controllers\AdminHomepage;

use App\Http\Controllers\Controller;
use App\User;
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
        $users = User::where('role', 1)->latest()->paginate(20);
        return view('admin_homepage.users.index', compact('users'))
            ->with('i', (request()->input('page', 1)-1)*20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('admin_homepage.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email_name = preg_replace('/\s*/', '', $request['name']);
        $email_name = strtolower($email_name);
        $this->validate_input($request);

        $data_user = [
            'password' => Hash::make(\Carbon\Carbon::parse($request['birth_date'])->format('dmY'))
        ];
        $user_created = User::create($request->all() + $data_user);
        if ($user_created) {
            $data_user_detail = [
                'full_name' => $user_created->name,
                'ref_user_id' => $user_created->id,
                'user_id' => $user_created->id,
                'confirmed' => true
            ];
            UserDetail::create($request->all() + $data_user_detail);
            return redirect()->route('admin.homepage.users.index')
                            ->with('success','Tambah Data jemaat Berhasil');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin_homepage.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin_homepage.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
