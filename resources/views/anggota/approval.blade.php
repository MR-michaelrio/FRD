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
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($anggota as $agt)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $agt->name }}</td>
                        <td>{{ $agt->email }}</td>
                        <td>{{ $agt->isApproved() ? 'active' : 'pending' }}</td>
                        <td>{{ $agt->wilayah }}</td>
                        <td>
                            @if(!$agt->isApproved())
                                <form method="POST" action="{{ route('approveUser'.$agt->id) }}">
                                    @csrf
                                    <button type="submit">Approve</button>
                                </form>
                            @endif
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