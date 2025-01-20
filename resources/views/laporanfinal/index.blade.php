@extends('template.master')

@section('title')
Laporan Final
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
                        <th>Nama Petugas</th>
                        <th>Tanggal</th>
                        <th>Regu</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($laporan as $lp)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $lp->nama_petugas }}</td>
                        <td>{{ $lp->tanggal }}</td>
                        <td>
                            <form action="{{route('laporan.destroy',$lp->id_laporan)}}" method="post">
                                @csrf
                                @METHOD('DELETE')
                                <a href="{{route('laporan.show',$lp->id_laporan)}}"><button type="button" class="btn btn-secondary">Lihat Laporan</button></a>&nbsp
                                <a href="{{route('laporan.edit',$lp->id_kejadian)}}"><button type="button" class="btn btn-warning">Edit</button></a>&nbsp
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this data?')">Delete</button>
                            </form>
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