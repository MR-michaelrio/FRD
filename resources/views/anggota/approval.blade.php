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
                        <td>{{ $agt->id }}</td>
                        <td>{{ $agt->name }}</td>
                        <td>{{ $agt->email }}</td>
                        <td>{{ $agt->status }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if(!$agt->isApproved())
                                    <form method="POST" action="{{ route('approveUser', $agt->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                @endif
                                @if(Auth::user()->level == "admin")
                                <form id="deleteForm-{{ $agt->id }}" method="POST" action="{{ route('deleteapproveUser', $agt->id) }}">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm ml-2" onclick="confirmDelete({{ $agt->id }})">Delete</button>
                                </form>
                                @endif
                            </div>
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