@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
    
        <div class="right-wrapper pull-right mr-md">
            <ol class="breadcrumbs mr-xl">
                <li>
                    <a href="{{route('admin.home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>List Pendaftaran Ibadah</span></li>
            </ol>
        </div>
    </header>
    <div class="row">
        <div class="col-md-6">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <a class="btn btn-success pull-right" href="{{ route('admin.ticket_registrations.create') }}"> Tambah Pendaftaran Ibadah</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title">Data Pendaftaran Ibadah</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Ibadah</th>
                                    <th>Jadwal Ibadah</th>
                                    <th>Jadwal Registrasi</th>
                                    <th>Maksimum Jemaat</th>
                                    <th>Total Jemaat Daftar</th>
                                    <th>Sisa Slot</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $ticket->date }}</td>
                                        <td>{{ $ticket->activity->name }}</td>
                                        <td>{{ $ticket->activity_schedule->name }}</td>
                                        <td>{{ $ticket->registration_start_date }} to {{ $ticket->registration_end_date }}</td>
                                        <td>{{ $ticket->max_participants }}</td>
                                        <td>{{ $ticket->count_registered()}}</td>
                                        <td>{{ $ticket->remaining_slot()}}</td>
                                        <td>
                                            <form action="{{ route('admin.ticket_registrations.destroy',$ticket->id) }}" method="POST">

                                                <a class="btn btn-primary" href="{{ route('admin.ticket_registrations.edit',$ticket->id) }}">Detail</a>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>            
        </div>
    </div>
    {{-- pagination --}}
    {!! $tickets->links() !!}
</section>
@endsection