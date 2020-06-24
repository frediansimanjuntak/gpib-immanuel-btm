@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Daftar Ibadah</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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

                    <form action="{{ route('activity_registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
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
                            </div>
                            @error('activity_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Pilih Jadwal Ibadah</label>
                            <div class="col-md-9">
                                <select class="form-control @error('activity_schedule_id') is-invalid @enderror" name="activity_schedule_id">   
                                    <option value="">-- Pilih Jadwal Ibadah --</option>                                      
                                    @foreach ($activity_schedules as $schedule)
                                      <option value="{{ $schedule->id }}"> 
                                          {{ $schedule->name }} -- Waktu Ibadah : ( {{$schedule->start_time}} - {{$schedule->end_time}} )
                                      </option>
                                    @endforeach    
                                </select>
                            </div>
                            @error('activity_schedule_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Tanggal</label>
                            <div class="col-md-9">
                                <input type="text" name="date" class="form-control @error('date') is-invalid @enderror datepicker" value="{{ old('date') }}">
                            </div>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-danger" href="{{ route('home') }}"> Back</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
