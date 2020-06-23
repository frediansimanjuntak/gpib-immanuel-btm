@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Ubah Activity</h2>
    
        <div class="right-wrapper pull-right mr-md">
            <ol class="breadcrumbs mr-xl">
                <li>
                    <a href="{{route('admin.home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.activities.index')}}">
                        <span>Activity</span>
                    </a>
                </li>
                <li><span>Ubah</span></li>
            </ol>
        </div>
    </header>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title">Ubah Activity</h2>
                </header>
                <div class="panel-body">
                    <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Nama</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $activity->name }}" class="form-control" placeholder="Nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Deskripsi</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="textareaDefault" name="description">{{ $activity->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Confirmed</label>
                            <div class="col-md-9">
                                <input type="checkbox" name="confirmed" {{$activity->confirmed?'checked':''}}> 
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-danger" href="{{ route('admin.activities.index') }}"> Back</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    <a class="btn btn-success pull-right" href="{{ route('admin.activities.activity_schedules.create', $activity->id) }}"> Tambah Activity Schedule</a>
                    <h2 class="panel-title">Activity Schedules</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Activity</th>
                                    <th>Waktu</th>
                                    <th>Confirmed</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activity_schedules as $key => $activity_schedule)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $activity_schedule->name }}</td>
                                        <td>{{ $activity_schedule->start_time }} - {{$activity_schedule->end_time}}</td>
                                        <td>{{ $activity_schedule->confirmed }}</td>
                                        <td>
                                            <form action="{{ route('admin.activities.activity_schedules.destroy', [$activity->id, $activity_schedule->id]) }}" method="POST">
                                                <a class="btn btn-primary" href="{{ route('admin.activities.activity_schedules.edit', [$activity->id, $activity_schedule->id]) }}">Ubah</a>

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
</section>
@endsection