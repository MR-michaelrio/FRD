@extends('template.master')

@section('title')
Lembaga
@endsection

@section('content')
<div class="col-12">
    <div class="card card-primary">
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('lembaga.update', $lembaga->id_lembaga) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @METHOD('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Lembaga</label>
                    <input type="text" class="form-control" name="nama_lembaga" value="{{ $lembaga->nama_lembaga }}" required>
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="logo_lembaga" accept="image/*">
                    @if($lembaga->logo_lembaga)
                        <p class="mt-2">Logo Saat Ini:</p>
                        <img src="{{ asset($lembaga->logo_lembaga) }}" width="100">
                    @endif                
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