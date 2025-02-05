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
                    <label for="exampleInputFile">Logo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="logo_lembaga" accept="image/*">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    @if($lembaga->logo_lembaga)
                        <p class="mt-2">Logo Saat Ini:</p>
                        <img src="{{ asset($lembaga->logo_lembaga) }}" class="img-thumbnail" width="250">
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
<script>
    document.querySelector(".custom-file-input").addEventListener("change", function(e) {
        let fileName = e.target.files[0].name;
        this.nextElementSibling.innerText = fileName;
    });
</script>

@endsection