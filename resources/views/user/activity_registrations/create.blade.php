@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
            <div class="card">
                <div class="card-header">DAFTAR IBADAH</div>
                <div class="card-body">
                    <form action="{{ route('activity_registrations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="inputDefault">Pilih Ibadah</label>
                            <div class="col-md-12">
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
                            <label class="col-md-12 control-label" for="inputDefault">Pilih Jadwal Ibadah</label>
                            <div class="col-md-12">
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
                            <label class="col-md-12 control-label" for="inputDefault">Tanggal</label>
                            <div class="col-md-12">
                                <input type="text" name="date" class="form-control @error('date') is-invalid @enderror datepicker" value="{{ old('date') }}">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <div class="col-md-12">
                                <a class="btn btn-danger" href="{{ route('home') }}"> Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
