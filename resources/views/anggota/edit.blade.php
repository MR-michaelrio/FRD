@extends('template.master')

@section('title')
Anggota
@endsection

@section('content')
<div class="col-12">
    <div class="card card-primary">
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{route('anggota.update',$data->id_anggota)}}">
            @csrf
            @METHOD('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Input Nama" value="{{ $data->nama }}" required>
                </div>
                <div class="form-group">
                    <label>Lembaga</label>
                    <select class="form-control select3" name="lembaga" style="width: 100%;" required>
                        @foreach($lembaga as $l)
                            <option value="{{ $l->id_lembaga }}" 
                                {{ $l->id_lembaga == old('lembaga', $data->id_lembaga ?? '') ? 'selected' : '' }}>
                                {{ ucwords($l->nama_lembaga) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $data->email }}" placeholder="Input Email">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" name="tanggal_lahir" placeholder="dd/mm/yyyy" value="{{ $data->tanggal_lahir }}">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" value="Laki-laki"
                            name="jenis_kelamin" @if($data->jenis_kelamin == 'Laki-laki') checked @endif>
                        <label for="customRadio1" class="custom-control-label">Laki-laki</label>
                    </div>
                    <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" value="Perempuan"
                            name="jenis_kelamin" @if($data->jenis_kelamin == 'Perempuan') checked @endif>
                          <label for="customRadio2" class="custom-control-label">Perempuan</label>
                        </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" name="alamat" value="{{ $data->alamat }}" placeholder="Input Alamat">
                </div>

                <div class="form-group">
                    <label>Nomor Pemegang</label>
                    <input type="text" class="form-control" name="no_pemegang" value="{{ $data->no_pemegang }}" placeholder="Input Nomor Pemegang">
                </div>
                <div class="form-group">
                    <label>Nomor Darurat 1</label>
                    <input type="text" class="form-control" name="no_darurat1" value="{{ $data->no_darurat1 }}" placeholder="Input Nomor Darurat">
                </div>
                <div class="form-group">
                    <label>Nama Darurat 1</label>
                    <input type="text" class="form-control" name="nama_darurat1" value="{{ $data->nama_darurat1 }}" placeholder="Input Nama Darurat 1">
                </div>
                <div class="form-group">
                    <label>Nomor Darurat 2</label>

                    <input type="text" class="form-control" name="no_darurat2" value="{{ $data->no_darurat2 }}" placeholder="Input Nomor Darurat 2">
                </div>
                <div class="form-group">
                    <label>Nama Darurat 2</label>
                    <input type="text" class="form-control" name="nama_darurat2" value="{{ $data->nama_darurat2 }}" placeholder="Input Nama Darurat 2">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control select2" name="role" style="width: 100%;">
                        <option value="anggota" @if($data->role == 'anggota') selected @endif>Anggota</option>
                        <option value="101" @if($data->role == '101') selected @endif>101</option>
                        <option value="102" @if($data->role == '102') selected @endif>102</option>
                        <option value="201" @if($data->role == '201') selected @endif>201</option>
                        <option value="202" @if($data->role == '202') selected @endif>202</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Regu</label>
                    <select class="form-control select2" name="id_regu" style="width: 100%;">
                        <!-- <option value="-" @if($data->id_regu == '-') selected @endif>-</option> -->
                        @foreach($regu as $r)
                            <option value="{{ $r->id_regu }}" @if($data->id_regu == $r->id_regu) selected @endif>@if($r->nama_regu == "null")-@else{{ $r->nama_regu }}@endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Wilayah</label>
                    <select class="form-control select2" name="wilayah" style="width: 100%;">
                        <option value="jakarta" @if($data->wilayah == 'jakarta') selected @endif>Jakarta</option>
                        <option value="bekasi" @if($data->wilayah == 'bekasi') selected @endif>Bekasi</option>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection