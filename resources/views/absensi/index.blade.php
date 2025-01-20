@extends('template.master')

@section('title')
Absen
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
                        <th>Tanggal Absen</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($absen as $agt)
                    <tr>
                        <td>{{ $agt->id_absen }}</td>
                        <td>{{ \Carbon\Carbon::parse($agt->tanggal_absen)->format('d-m-Y') }}</td>
                        <td>{{ $agt->catatan }}</td>
                        <td>
                            <form action="{{route('absen.destroy',$agt->id_absen)}}" method="post">
                                @csrf
                                @METHOD('DELETE')
                                <a href="{{ $agt->pdf }}"><button type="button" class="btn btn-secondary">Download PDF</button></a>&nbsp
                                <a href="{{route('absen.show',$agt->id_absen)}}"><button type="button" class="btn btn-info">Lihat Absen</button></a>&nbsp
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