@extends('template.master')

@section('title')
Anggota 101 & 102
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
                        <th>Nama</th>
                        <th>Lembaga</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($anggota as $agt)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $agt->nama }}</td>
                        <td>{{ $agt->Lembaga->nama_lembaga || "NULL" }}</td>
                        <td>{{ $agt->role }}</td>
                        <td>
                            <form action="{{route('anggota.destroy',$agt->id_anggota)}}" method="post">
                                @csrf
                                @METHOD('DELETE')
                                <a href="{{route('anggota.edit',$agt->id_anggota)}}"><button type="button" class="btn btn-warning">Edit</button></a>&nbsp
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