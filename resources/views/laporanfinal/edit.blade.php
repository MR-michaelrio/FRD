@extends('template.master')

@section('title')
Laporan Final
@endsection

@section('content')
<div class="col-12">
    <div class="card card-primary">
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{route('laporan.update',$laporan->id_kejadian)}}">
            @csrf
            @METHOD('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Laporan</label>
                    <textarea name="kejadian" class="form-control" id="" cols="30" rows="30">{{ $laporan->kejadian }}</textarea>
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