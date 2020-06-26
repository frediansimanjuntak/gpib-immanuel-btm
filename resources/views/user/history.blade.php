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
            <div class="card">
                <div class="card-header">HISTORY DAFTAR IBADAH</div>
                <div class="card-body">
                    <table class="table mb-none">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Registrasi</th>
                                <th>Nama</th>
                                <th>Lokasi Ibadah</th>
                                <th>Jadwal Ibadah</th>
                                <th>Tanggal Ibadah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity_registrations as $activity_registration)
                                <tr>
                                    @if ($activity_registration->user->user_detail && $activity_registration->user->user_detail->ref_user_id == Auth::user()->id)
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $activity_registration->registration_number }}</td>
                                        <td>{{ $activity_registration->user->user_detail->full_name }}</td>
                                        <td>{{ $activity_registration->activity->name }}</td>
                                        <td>{{ $activity_registration->activity_schedule->name }} ({{ \Carbon\Carbon::parse($activity_registration->activity_schedule->start_time)->isoFormat('hh:mm')}} - {{ \Carbon\Carbon::parse($activity_registration->activity_schedule->end_time)->isoFormat('hh:mm') }})</td>
                                        <td>{{ \Carbon\Carbon::parse($activity_registration->date)->isoFormat('dddd, D MMMM Y') }}</td>       
                                        <td>
                                            @if($activity_registration->available_registration())
                                                <a class="btn btn-danger" href="{{ route('activity_registration.cancelled', [$activity_registration->id, Auth::user()->id]) }}">Cancel</a>
                                            @endif
                                            {{ $activity_registration->cancelled ? "CANCELLED" : "" }}
                                        </td>                                 
                                    @endif 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- pagination --}}
                    {!! $activity_registrations->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
