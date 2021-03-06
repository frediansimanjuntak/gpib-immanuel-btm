<?php

namespace App\Http\Controllers\AdminHomepage;

use App\Http\Controllers\Controller;
use App\User;
use App\UserDetail;
use App\UserType;
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
        $user_types = UserType::where('confirmed', true)->pluck('name', 'id');
        return view('admin_homepage.users.create', compact('user_types'));
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
        $this->validate_input_create($request);
        $request['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('Y-m-d');
        $request['password'] = Hash::make($request['password']);
        $user_created = User::create($request->all());
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
        return view('admin_homepage.users.show', compact('user', 'user_detail', 'family', 'user_types'))
        ->with('i', (request()->input('page', 1)-1)*10);
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
        $this->validate_input_edit($request);

        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $request['birth_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['birth_date'])->format('Y-m-d');
        if ($request['password']){
            $request['password'] = Hash::make($request['password']);
        }
        $data_user_details = [
            'full_name' => $request['name'],
        ];
        $request_only = $request->all();
        $requests_without_null_fields =  array_filter($request_only);
        
        $user->update($requests_without_null_fields);
        $user_detail->update($requests_without_null_fields + $data_user_details);

        return redirect()->route('admin.homepage.users.index')
            ->with('success','Ubah Data jemaat Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.homepage.users.index')
                        ->with('success','User deleted successfully');
    }

    private function validate_input_create($request) 
    {
        $rules = [            
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'max:12', 'unique:user_details'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'birth_date.date_format' => 'Format Tanggal salah harus tanggal/bulan/tahun (31/12/1993)',
            'user_type_id.required' => 'Pilih Sektor tidak boleh kosong',
        ];

        $this->validate($request, $rules, $customMessages);
    }
}
