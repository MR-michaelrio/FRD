@extends('template.master')

@section('title')
Laporan
@endsection

@section('content')

<div class="col-12">
    <div class="card card-primary">
        <form role="form" action="{{ route('lpr.store') }}" method='POST'>
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Kejadian</label>
                    <input type="text" class="form-control" name="kejadian" placeholder="Jaya 65 Jakarta Timur">
                </div>
                <div class="form-group">
                    <label>Objek</label>
                    <input type="text" class="form-control" name="objek" placeholder="Rumah">
                </div>
                <div class="form-group">
                    <label>Tanggal Terima Berita</label>
                    <input type="text" class="form-control" id="dateInput" autocomplete="off" name="tanggal" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                </div>
                <div class="form-group">
                    <label>Waktu Terima Berita</label>
                    <input type="text" class="form-control" name="terima_berita" placeholder="11:00">
                </div>
                <div class="form-group">
                    <label>Situasi</label>
                    <input type="text" class="form-control" name="situasi" placeholder="Merah">
                </div>
                <div class="form-group">
                    <label>Pengerahan Unit Akhir (Khusus 65)</label>
                    <input type="text" class="form-control" name="pengerahan_akhir" placeholder="110">
                </div>
                
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="2" name="alamat" placeholder="ALAMAT"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Responder</label>
                    <textarea class="form-control" rows="4" name="responder" placeholder="- GMCI 1 Personil"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection