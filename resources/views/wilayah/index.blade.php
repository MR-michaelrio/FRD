@extends('template.master')

@section('title')
    Wilayah
@endsection

@section('css')
    <style>
        .status-select {
            padding: 5px;
            border-radius: 5px;
            width: 100%;
        }

        .status-select option[value="menunggu persetujuan"] {
            background-color: #ffc107; /* Kuning */
        }

        .status-select option[value="disetujui"] {
            background-color: #28a745; /* Hijau */
        }

        .status-select option[value="ditolak"] {
            background-color: #dc3545; /* Merah */
        }
    </style>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Wilayah</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($wilayah as $w)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ $w->supervisor }}</td>
                        <td>
                            <select class="status-select" data-id="{{ $w->id }}" onchange="updateStatus(this)">
                                <option value="menunggu persetujuan" @if($w->status == 'menunggu persetujuan') selected @endif>Menunggu Persetujuan</option>
                                <option value="disetujui" @if($w->status == 'disetujui') selected @endif>Disetujui</option>
                                <option value="ditolak" @if($w->status == 'ditolak') selected @endif>Ditolak</option>
                            </select>
                        </td>
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