@extends('template.master')

@section('title', 'Edit Lembaga')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Lembaga</h3>
            </div>
            <form action="{{ route('lembaga.update', $lembaga->id_lembaga) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_lembaga">Nama Lembaga</label>
                        <input type="text" class="form-control" id="nama_lembaga" name="nama_lembaga" value="{{ $lembaga->nama_lembaga }}" required>
                    </div>
                    <div class="form-group">
                        <label for="logo_lembaga">Logo Lembaga</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo_lembaga" name="logo_lembaga" accept="image/*">
                                <label class="custom-file-label" for="logo_lembaga">Pilih Logo</label>
                            </div>
                        </div>
                        @if($lembaga->logo_lembaga)
                            <div class="mt-3">
                                <p>Logo Saat Ini:</p>
                                <img src="{{ asset($lembaga->logo_lembaga) }}" class="img-thumbnail" width="120">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('lembaga.index') }}" class="btn btn-default">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
