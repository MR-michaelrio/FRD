@extends('template.master')

@section('title')
Anggota
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr><td><a href="{{ route('anggota.create') }}" class="btn btn-secondary">Tambah</a></td></tr>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Lembaga</th>
                        <th>Role</th>
                        <th>Regu</th>
                        <th>Wilayah</th>
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
                        <td>{{ $agt->Lembaga->nama_lembaga }}</td>
                        <td>{{ $agt->role }}</td>
                        <td>{{ $agt->wilayah }}</td>
                        <td>
                            @if($agt->id_regu == '4')
                                -
                            @elseif($agt->id_regu == '1')
                                Regu A
                            @elseif($agt->id_regu == '2')
                                Regu B
                            @elseif($agt->id_regu == '3')
                                Regu C
                            @endif
                        </td>
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