@extends('template.master')

@section('title')
Laporan
@endsection

@section('content')
<div class="col-12">
    <form action="{{ route('search') }}" method="get">
        <div class="card">
            <div class="input-group">
                <input type="text" class="form-control" id="dateInput" name="table_search" data-provide="datepicker" autocomplete="off" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    @forelse($tiket as $a)
    <div class="card @if($a->status=='selesai')card-success @else card-danger @endif">
        <div class="card-header">
            <h3 class="card-title">Laporan Kejadian FRD</h3>

            <div class="card-tools">
                
                <form action="{{route('lpr.destroy',$a->id_kejadian)}}" method="post">
                    @csrf
                    @METHOD('DELETE')
                    @if($a->status != 'selesai')
                    <a href="{{ route('lpr.edit',$a->id_kejadian) }}" class="btn btn-warning">Update</a>
                    @else
                    <a href="{{ route('lpr.edit',$a->id_kejadian) }}" class="btn btn-warning">Edit</a>
                    @endif
                    @if(auth()->user()->level == "admin")
                    <button type="submit" class="btn btn-danger border" onclick="return confirm('Are you sure you want to delete this data?')">Delete</button>
                    @endif
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </form>
                
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-12">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <tr>
                                <th>Jenis Kejadian</th>
                                <td>{{ $a->kejadian }}</td>
                            </tr>
                            <tr>
                                <th>Waktu Kejadian</th>
                                <td>{{ $a->terima_berita }} </td>
                            </tr>
                            <tr>
                                <th>Tanggal Kejadian</th>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }} </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $a->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Responder</th>
                                <td>{!! nl2br($a->responder) !!} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    @empty
    <div class="card card-primary">
        <div class="card-body" style="display: block;">
            Tidak Ada Laporan
        </div>
        <!-- /.card-body -->
    </div>
    @endforelse

    @forelse($damkar as $b)
    <div class="card @if(!empty($b->waktu_selesai_operasi))card-info @else card-danger @endif">
        <div class="card-header">
            <h3 class="card-title">Laporan Kejadian DAMKAR</h3>
            <!-- /.card-tools -->
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-12">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <tr>
                                <th>Jenis Kejadian</th>
                                <td>{{ $b->judul }}</td>
                            </tr>
                            <tr>
                                <th>Waktu Kejadian</th>
                                <td>{{ $b->waktu_terima_berita }} </td>
                            </tr>
                            <tr>
                                <th>Tanggal Kejadian</th>
                                <td>{{ $b->hari_tgl }} </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $b->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Responder</th>
                                <td><a href="{{$b->maps}}">{{$b->maps}}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    @empty
    <div class="card card-primary">
        <div class="card-body" style="display: block;">
            Tidak Ada Laporan
        </div>
        <!-- /.card-body -->
    </div>
    @endforelse
</div>
@endsection