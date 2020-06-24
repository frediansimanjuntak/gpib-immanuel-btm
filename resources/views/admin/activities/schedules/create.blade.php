@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Tambah Jadwal Ibadah</h2>
    
        <div class="right-wrapper pull-right mr-md">
            <ol class="breadcrumbs mr-xl">
                <li>
                    <a href="{{route('admin.home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.activities.edit', $activity->id)}}">
                        <span>Data Jadwal -- {{$activity->name}}</span>
                    </a>
                </li>
                <li><span>Tambah</span></li>
            </ol>
        </div>
    </header>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
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
    
                    <h2 class="panel-title">Tambah Jadwal Ibadah</h2>
                </header>
                <div class="panel-body">
                    <form action="{{ route('admin.activities.activity_schedules.store', $activity->id) }}" method="POST">
                        @csrf
                        <input name="activity_id" type="hidden" value="{{$activity->id}}">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Nama</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Deskripsi</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Waktu Mulai</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>                                    
                                    <input type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }' name="start_time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Waktu Selesai</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>                                    
                                    <input type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }' name="end_time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Confirmed</label>
                            <div class="col-md-9">
                                <input type="checkbox" name="confirmed"> 
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-danger" href="{{ route('admin.activities.edit', $activity->id) }}"> Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection