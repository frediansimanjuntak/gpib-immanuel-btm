@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
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
                <div class="card-header">DATA Anggota Keluarga</div>
                <div class="card-body">                    
                    <form action="{{ route('user.store', Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('name') text-danger @enderror" for="inputDefault">Nama Lengkap *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('phone_number') text-danger @enderror" for="inputDefault">No. Handphone *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{old('phone_number') }}">
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="inputDefault">Hubungan Keluarga</label>
                                    <div class="col-md-12">
                                        <select class="form-control @error('family_status') is-invalid @enderror" name="family_status">   
                                            <option value="ayah" {{ old('phone_number') == "ayah" ? "selected" : ""}}>AYAH</option>  
                                            <option value="ibu" {{ old('phone_number') == "ibu" ? "selected" : ""}}>IBU</option>  
                                            <option value="anak" {{ old('phone_number') == "anak" ? "selected" : ""}}>ANAK</option>
                                        </select>
                                        @error('family_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('full_address') text-danger @enderror" for="inputDefault">Alamat Lengkap *</label>
                                    <div class="col-md-12">
                                        <textarea rows="5" class="form-control @error('full_address') is-invalid @enderror" name="full_address">{{ old('full_address') }}</textarea>
                                        @error('full_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if ($user_types)
                                    <div class="form-group">
                                        <label class="col-md-12 control-label @error('user_type_id') text-danger @enderror" for="inputDefault">Pilih Sektor *</label>
                                        <div class="col-md-12">
                                            <select class="form-control @error('user_type_id') is-invalid @enderror" name="user_type_id" id="user_type_id">   
                                                <option value="">-- Pilih Sektor --</option>                                      
                                                @foreach ($user_types as $key => $value)
                                                <option value="{{ $key }}" {{old('user_type_id') == $key ? "selected" : ""}}> 
                                                    {{ $value }} 
                                                </option>
                                                @endforeach    
                                            </select>
                                            @error('user_type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="text-primary">
                                                <strong>Note: Jika bukan warga sidi jemaat, silahkan pilih "Simpatisan"</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('identity_type') text-danger @enderror" for="inputDefault">Tipe Identitas *</label>
                                    <div class="col-md-12">
                                        <select class="form-control @error('identity_type') is-invalid @enderror" name="identity_type">   
                                            <option value="ktp" {{ old('identity_type') == "ktp" ? "selected" : ""}}>KTP</option>  
                                            <option value="passport" {{ old('identity_type') == "passport" ? "selected" : ""}}>PASSPORT</option>  
                                            <option value="sim" {{ old('identity_type') == "sim" ? "selected" : ""}}>SIM</option>
                                        </select>
                                        @error('identity_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                   
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('identity_number') text-danger @enderror" for="inputDefault">Nomer Identitas *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="identity_number" class="form-control @error('identity_number') is-invalid @enderror" value="{{ old('identity_number') }}">
                                        @error('identity_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('family_card_number') text-danger @enderror" for="inputDefault">Nomer Kartu Keluarga *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="family_card_number" class="form-control @error('family_card_number') is-invalid @enderror" value="{{ old('family_card_number') }}">
                                        @error('family_card_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                 
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('gender') text-danger @enderror" for="inputDefault">Jenis Kelamin</label>
                                    <div class="col-md-12">
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender">   
                                            <option value="laki-laki" {{ old('gender') == "laki-laki" ? "selected" : ""}}>LAKI - LAKI</option>  
                                            <option value="perempuan" {{ old('gender') == "perempuan" ? "selected" : ""}}>PEREMPUAN</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('birth_place') text-danger @enderror" for="inputDefault">Tempat Lahir *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" value="{{ old('birth_place') }}">
                                        @error('birth_place')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label @error('birth_date') text-danger @enderror" for="inputDefault">Tanggal Lahir *</label>
                                    <div class="col-md-12">
                                        <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <div class="col-md-12">
                                        <a class="btn btn-danger" href="{{ route('user.profile', Auth::user()->id) }}"> Kembali</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
