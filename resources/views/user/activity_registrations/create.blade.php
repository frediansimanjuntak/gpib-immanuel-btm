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
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="inputDefault">Pilih Ibadah</label>
                            <div class="col-md-12">
                                <select class="form-control @error('activity_id') is-invalid @enderror" name="activity_id" id="activity_id">   
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
                                <select class="form-control @error('activity_schedule_id') is-invalid @enderror" name="activity_schedule_id" id="activity_schedule_id">   
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
                            <label class="col-md-12 control-label" for="inputDefault">Pilih Tanggal Ibadah</label>
                            <div class="col-md-12">
                                <select class="form-control @error('ticket_registration_id') is-invalid @enderror" name="ticket_registration_id" id="ticket_registration_id">   
                                    <option value="">-- Pilih Tanggal Ibadah --</option> 
                                    {{-- @foreach ($ticket_registrations as $ticket)
                                      <option value="{{ $ticket->id }}"> 
                                          {{ $ticket->date }} 
                                      </option>
                                    @endforeach  --}}
                                </select>
                                @error('ticket_registration_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if (count(Auth::user()->family_member()) > 1)
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="inputDefault">Pilih Anggota Keluarga</label>
                                <div class="col-md-12">
                                    @foreach (Auth::user()->family_member() as $family)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="user_ids[]" value="{{ $family->user->id }}">
                                                {{ $family->full_name }}
                                            </label>
                                        </div>                                    
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="user_ids[]" value="{{Auth::user()->id}}">
                        @endif
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
