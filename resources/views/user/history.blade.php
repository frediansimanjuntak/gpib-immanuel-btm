@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">HISTORY DAFTAR IBADAH</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table mb-none">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Ibadah</th>
                                <th>Sesi Ibadah</th>
                                <th>Jadwal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity_registrations as $activity_registration)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $activity_registration->activity->name }}</td>
                                    <td>{{ $activity_registration->activity_schedule->name }}</td>
                                    <td>{{ $activity_registration->date }}</td>
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
