@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Ubah Pendaftaran</h2>
    
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
                <li><span>Ubah</span></li>
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
    
                    <h2 class="panel-title">Ubah Pendaftaran</h2>
                </header>
                <div class="panel-body">
                    <form action="{{ route('admin.ticket_registrations.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Pilih Ibadah</label>
                                    <div class="col-md-9">
                                        <select class="form-control @error('activity_id') is-invalid @enderror" name="activity_id">   
                                            <option value="">-- Pilih Ibadah --</option>                                      
                                            @foreach ($activities as $key => $value)
                                                <option value="{{ $key }}" {{$key == $ticket->activity_id ? "selected":""}}> 
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
                                            @foreach ($activity_schedules as $key => $value)
                                                <option value="{{ $key }}" {{$key == $ticket->activity_schedule_id ? "selected":""}}> 
                                                    {{ $value }} 
                                                </option>
                                            @endforeach 
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
                                    <input type="date" name="date" class="form-control" placeholder="Date" value="{{$ticket->date}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Total Maksimal Jemaat</label>
                                    <div class="col-md-9">
                                    <input type="number" name="max_participants" class="form-control" placeholder="0" value="{{$ticket->max_participants}}">
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
                                            <input type="date" class="form-control" name="registration_start_date" value="{{$ticket->registration_start_date}}">
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
                                            <input type="date" class="form-control" name="registration_end_date" value="{{$ticket->registration_end_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="inputDefault">Confirmed</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="status" {{$ticket->status == "on" ? "checked" : ""}}> 
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
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title">List Pendaftar</h2>
                </header>
                <div class="panel-body">
                    <a class="btn btn-success" href="{{ route('admin.export.activity_registration', $ticket->id) }}"> Export to excel</a>
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Telp</th>
                                    <th>No. Registrasi</th>
                                    <th>Sektor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticket->active_activity_registration() as $key => $activity_registrations)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $activity_registrations->user->name }}</td>
                                        <td>{{ $activity_registrations->user->email }}</td>
                                        <td>{{ $activity_registrations->user->phone_number() }}</td>
                                        <td>{{ $activity_registrations->registration_number }}</td>
                                        <td>{{ $activity_registrations->user->sektor() }}</td>
                                        <td>
                                            <form action="{{ route('admin.ticket_registration.activity_registration.destroy',[$ticket, $activity_registrations->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah setuju User ini akan dihapus dari pendaftaran ibadah?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>    
                    <h2 class="panel-title">List Pendaftar Cancel</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Telp</th>
                                    <th>No. Registrasi</th>
                                    <th>Sektor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticket->cancelled_activity_registration() as $key => $activity_registrations)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $activity_registrations->user->name }}</td>
                                        <td>{{ $activity_registrations->user->email }}</td>
                                        <td>{{ $activity_registrations->user->phone_number() }}</td>
                                        <td>{{ $activity_registrations->registration_number }}</td>
                                        <td>{{ $activity_registrations->user->sektor() }}</td>
                                        <td>
                                            <form action="{{ route('admin.ticket_registration.activity_registration.destroy',[$ticket, $activity_registrations->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah setuju User ini akan dihapus dari pendaftaran ibadah?')">Hapus</button>
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