@extends('template.master')

@section('title')
Laporan
@endsection

@section('content')

<div class="col-12">
    <div class="card card-primary">
        <form role="form" action="" id="laporanForm" method='POST'>
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Kejadian</label>
                    <input type="text" class="form-control" name="kejadian" value="{{ $a->kejadian }}" placeholder="Jaya 65 Jakarta Timur">
                </div>
                <div class="form-group">
                    <label>Objek</label>
                    <input type="text" class="form-control" name="objek" value="{{ $a->objek }}" placeholder="Rumah">
                </div>
                <div class="form-group">
                    <label>Tanggal Terima Berita</label>
                    <input type="text" class="form-control" id="dateInput" name="tanggal" value="{{ $a->tanggal }}" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                </div>
                <div class="form-group">
                    <label>Waktu Terima Berita</label>
                    <input type="text" class="form-control" name="terima_berita" value="{{ $a->terima_berita }}" placeholder="11:00">
                </div>
                <div class="form-group">
                    <label>Situasi (Jika Ada Perubahan Mohon Di update)</label>
                    <input type="text" class="form-control" name="situasi" value="{{ $a->situasi }}" placeholder="Merah">
                </div>
                <div class="form-group">
                    <label>Pengerahan Unit Akhir (Khusus 65)</label>
                    <input type="text" class="form-control" name="pengerahan_akhir" value="{{ $a->pengerahan_akhir }}" placeholder="110">
                </div>
                <div class="form-group">
                    <label>Waktu Selesai (Khusus 65)</label>
                    <input type="text" class="form-control" name="waktu_selesai" value="{{ $a->waktu_selesai }}" placeholder="13:30">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="2" name="alamat" placeholder="ALAMAT">{{ $a->alamat }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Responder</label>
                    <textarea class="form-control" rows="4" name="responder" placeholder="- GMCI 1 Personil">{{ $a->responder }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                @if($a->status == 'aktif')
                    <button type="button" class="btn btn-warning" onclick="submitForm('update')">Update</button>
                    <button type="button" class="btn btn-success" onclick="submitForm('selesai')">Selesai</button>
                @else  
                    <button type="button" class="btn btn-warning" onclick="submitForm('update')">Submit</button>
                @endif
            </div>
        </form>
    </div>
</div>
<script>
    function submitForm(action) {
        var form = document.getElementById('laporanForm');
        
        if (action === 'update') {
            form.action = "{{ route('lpr.update', $a->id_kejadian) }}";
        } else if (action === 'selesai') {
            form.action = "{{ route('lpr.selesai', $a->id_kejadian) }}";
        }

        form.submit();
    }
</script>
@endsection