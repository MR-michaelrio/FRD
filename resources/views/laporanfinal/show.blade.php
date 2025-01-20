@extends('template.master')

@section('title')
Laporan {{ \Carbon\Carbon::parse($data->tanggal_kejadian)->format('d-m-Y') }}
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Kejadian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $agt)
                    <tr>
                        <td>{!! nl2br($agt->Kejadian->kejadian) !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection 