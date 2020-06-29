@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">WELCOME!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Selamat Datang di Sistem Pelayanan GPIB IMMANUEL BATAM
                </div>
            </div>
        </div>
    </div>
</div>
@if (count($tickets_actived) > 0)
    @foreach ($tickets_actived as $ticket)
        @if (count(Auth::user()->family_activity_registered($ticket->id)) > 0)
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">JADWAL IBADAH ANDA PADA <div class="text-danger">{{\Carbon\Carbon::parse($ticket->date)->isoFormat('dddd, D MMMM Y') }} : {{$ticket->activity->name}} - {{$ticket->activity_schedule->name}} ({{$ticket->activity_schedule->start_time}} - {{$ticket->activity_schedule->end_time}})</div></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-none">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>No. Registrasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Auth::user()->family_activity_registered($ticket->id) as $key => $activity)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ $activity->user->name}}</td>
                                                    <td>{{ $activity->registration_number }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif

@endsection
