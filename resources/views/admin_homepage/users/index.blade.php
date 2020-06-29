@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="text-right mb-2">
                <a class="btn btn-success pull-right" href="{{ route('admin.homepage.users.create') }}"> Tambah User</a>
            </div>
            <div class="card">
                <div class="card-header">
                    DATA JEMAAT
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Phone Number</th>
                                    <th>Referensi User</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone_number() }}</td>
                                        <td>{{ $user->user_detail ? $user->user_detail->ref_user ? $user->user_detail->ref_user->name : "" : "-" }}</td>
                                        <td>
                                            <form action="{{ route('admin.homepage.users.destroy',$user->id) }}" method="POST">

                                                <a class="btn btn-primary" href="{{ route('admin.homepage.users.show',$user->id) }}">Detail</a>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah setuju user ini akan dihapus?')">Hapus</button>
                                            </form>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- pagination --}}
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
