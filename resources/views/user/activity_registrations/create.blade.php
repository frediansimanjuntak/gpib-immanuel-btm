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

                    <form action="{{ route('activity_registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Tanggal</label>
                            <div class="col-md-9">
                                <input type="date" name="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Pilih Ibadah</label>
                            <div class="col-md-9">
                                <select class="form-control" name="activity_id">   
                                    <option>-- Pilih Ibadah --</option>                                      
                                    @foreach ($activities as $key => $value)
                                      <option value="{{ $key }}"> 
                                          {{ $value }} 
                                      </option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Pilih Jadwal Ibadah</label>
                            <div class="col-md-9">
                                <select class="form-control" name="activity_schedule_id">   
                                    <option>-- Pilih Jadwal Ibadah --</option>                                      
                                    @foreach ($activity_schedules as $schedule)
                                      <option value="{{ $schedule->id }}"> 
                                          {{ $schedule->name }} -- Waktu Ibadah : ( {{$schedule->start_time}} - {{$schedule->end_time}} )
                                      </option>
                                    @endforeach    
                                </select>
                            </div>
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
