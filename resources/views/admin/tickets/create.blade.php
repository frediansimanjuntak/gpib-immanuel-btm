@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Buka Pendaftaran</h2>
    
        <div class="right-wrapper pull-right mr-md">
            <ol class="breadcrumbs mr-xl">
                <li>
                    <a href="{{route('admin.home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.ticket_registrations.index')}}">
                        <span>Pendaftaran Ibadah</span>
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
    
                    <h2 class="panel-title">Buka Pendaftaran</h2>
                </header>
                <div class="panel-body">
                    <form action="{{ route('admin.ticket_registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Pilih Ibadah</label>
                                    <div class="col-md-9">
                                        <select class="form-control @error('activity_id') is-invalid @enderror" name="activity_id">   
                                            <option value="">-- Pilih Ibadah --</option>                                      
                                            @foreach ($activities as $key => $value)
                                              <option value="{{ $key }}"> 
                                                  {{ $value }} 
                                              </option>
                                            @endforeach    
                                        </select>
                                        @error('activity_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Pilih Jadwal Ibadah</label>
                                    <div class="col-md-9">
                                        <select class="form-control @error('activity_schedule_id') is-invalid @enderror" name="activity_schedule_id">   
                                            <option value="">-- Pilih Jadwal Ibadah --</option> 
                                        </select>
                                        @error('activity_schedule_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Tanggal</label>
                                    <div class="col-md-9">
                                        <input type="date" name="date" class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Total Maksimal Jemaat</label>
                                    <div class="col-md-9">
                                        <input type="number" name="max_participants" class="form-control" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Waktu Mulai Pendaftaran</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>                                    
                                            <input type="dateTime-local" class="form-control" name="registration_start_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Waktu Selesai Pendaftaran</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>                                    
                                            <input type="dateTime-local" class="form-control" name="registration_end_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Status</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="status"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <a class="btn btn-danger" href="{{ route('admin.ticket_registrations.index') }}"> Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection