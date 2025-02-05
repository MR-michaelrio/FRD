@extends('template.master')

@section('title')
    Lembaga
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
                        <th>Nama Lembaga</th>
                        <th>Logo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($lembaga as $w)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $w->nama_lembaga }}</td>
                        <td>
                            @if($w->logo_lembaga)
                                <img src="{{ asset($w->logo_lembaga) }}" alt="Logo {{ $w->nama_lembaga }}" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('lembagas.edit', $w->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('lembagas.destroy', $w->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus lembaga ini?');
    }
</script>
@endsection