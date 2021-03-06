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
                <li><span>Pendaftar Ibadah</span></li>
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title">Data Pendaftar Ibadah</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Ibadah</th>
                                    <th>Jadwal Ibadah</th>
                                    <th>Tanggal Ibadah</th>
                                    <th>Registration Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activity_registrations as $act_regist)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $act_regist->user->name }}</td>
                                        <td>{{ $act_regist->activity->name }}</td>
                                        <td>{{ $act_regist->activity_schedule->name }} ({{$act_regist->activity_schedule->start_time}} - {{$act_regist->activity_schedule->end_time}})</td>
                                        <td>{{ $act_regist->date }}</td>
                                        <td>{{ $act_regist->registration_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- pagination --}}
                        {!! $activity_registrations->links() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection