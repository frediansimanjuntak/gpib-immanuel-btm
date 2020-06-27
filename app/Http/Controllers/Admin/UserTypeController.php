<?php

namespace App\Http\Controllers\Admin;

use App\UserType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTypeController extends Controller
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
        $user_types = UserType::latest()->paginate(20);
        return view('admin.user_types.index', compact('user_types'))
            ->with('i', (request()->input('page', 1)-1)*20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_types.create');
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
            'name' => 'required',
            'description' => 'required',
        ]);       
        $request['confirmed'] = $request['confirmed'] ? true : false;
       
        UserType::create($request->all());

        return redirect()->route('admin.user_types.index')
                        ->with('success','User type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_type = UserType::find($id);
        return view('admin.user_types.show',compact('user_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_type = UserType::find($id);
        return view('admin.user_types.edit',compact('user_type'));
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
            'description' => 'required',
        ]);
        $user_type = UserType::find($id);
        $request['confirmed'] = $request['confirmed'] ? true : false;

        $user_type->update($request->all());

        return redirect()->route('admin.user_types.index')
                        ->with('success','User type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_type = UserType::find($id);
        $user_type->delete();

        return redirect()->route('admin.user_types.index')
                        ->with('success','User type deleted successfully');
    }
}
