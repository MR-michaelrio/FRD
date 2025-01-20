@extends('template.master')

@section('title')
Anggota
@endsection

@section('content')
<div class="col-12">
    <div class="card card-primary">
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{route('anggota.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Input Nama" required>
                </div>
                <div class="form-group">
                    <label>Lembaga</label>
                    <input type="text" class="form-control" name="lembaga" placeholder="Input Lembaga">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Input Email">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" name="tanggal_lahir" placeholder="dd/mm/yyyy">
                </div>
                
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" value="Laki-laki"
                            name="jenis_kelamin">
                        <label for="customRadio1" class="custom-control-label">Laki-laki</label>
                    </div>
                    <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" value="Perempuan"
                            name="jenis_kelamin">
                          <label for="customRadio2" class="custom-control-label">Perempuan</label>
                        </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" name="alamat" placeholder="Input Alamat">
                </div>

                <div class="form-group">
                    <label>Nomor Pemegang</label>
                    <input type="text" class="form-control" name="no_pemegang" placeholder="Input Nomor Pemegang">
                </div>
                <div class="form-group">
                    <label>Nomor Darurat 1</label>
                    <input type="text" class="form-control" name="no_darurat1" placeholder="Input Nomor Darurat">
                </div>
                <div class="form-group">
                    <label>Nama Darurat 1</label>
                    <input type="text" class="form-control" name="nama_darurat1" placeholder="Input Nama Darurat 1">
                </div>
                <div class="form-group">
                    <label>Nomor Darurat 2</label>
                    <input type="text" class="form-control" name="no_darurat2" placeholder="Input Nomor Darurat 2">
                </div>
                <div class="form-group">
                    <label>Nama Darurat 2</label>
                    <input type="text" class="form-control" name="nama_darurat2	" placeholder="Input Nama Darurat 2">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control select2" name="role" style="width: 100%;">
                        <option value="anggota" selected>Anggota</option>
                        <option value="101">101</option>
                        <option value="102">102</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Regu</label>
                    <select class="form-control select2" name="id_regu" style="width: 100%;">
                        <option value="-" selected>-</option>
                        @foreach($regu as $r)
                        <option value="{{ $r->id_regu }}">{{ $r->nama_regu }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Wilayah</label>
                    <select class="form-control select2" name="wilayah" style="width: 100%;">
                        <option value="jakarta">Jakarta</option>
                        <option value="bekasi">Bekasi</option>
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