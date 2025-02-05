@extends('template.master')

@section('title')
    Edit Lembaga
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Lembaga</h4>
            <form action="{{ route('lembaga.update', $lembaga->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Lembaga</label>
                    <input type="text" class="form-control" name="nama_lembaga" value="{{ $lembaga->nama_lembaga }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo Lembaga</label>
                    <input type="file" class="form-control" name="logo_lembaga" accept="image/*">
                    @if($lembaga->logo_lembaga)
                        <p class="mt-2">Logo Saat Ini:</p>
                        <img src="{{ asset($lembaga->logo_lembaga) }}" width="100">
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('lembaga.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
