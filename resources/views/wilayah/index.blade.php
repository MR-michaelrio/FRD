@extends('template.master')

@section('title')
    Wilayah
@endsection

@section('css')
    <style>
        /* Styling untuk select */
.status-select {
    padding: 5px 15px;
    border-radius: 5px;
    width: 100%;
    border: 1px solid red;
}

.status-select option {
    padding: 10px;
    font-weight: bold;
}


    </style>
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
                        <th>Wilayah</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($wilayah as $w)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ $w->supervisor }}</td>
                        <td>
                            <select class="status-select" data-id="{{ $w->id }}" onchange="updateStatus(this)">
                                <option value="menunggu persetujuan" @if($w->status == 'menunggu persetujuan') selected @endif>Menunggu Persetujuan</option>
                                <option value="disetujui" @if($w->status == 'disetujui') selected @endif >Disetujui</option>
                                <option value="ditolak" @if($w->status == 'ditolak') selected @endif >Ditolak</option>
                            </select>
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
    function updateStatus(select) {
        const status = select.value;
        const wilayahId = select.getAttribute('data-id');

        // Mengirim request untuk update status
        axios.post('/update-status-wilayah', {
            wilayah_id: wilayahId,
            status: status
        })
        .then(function(response) {
            // Tidak perlu update tampilan status, karena sudah terupdate langsung dari select
            console.log('Status berhasil diperbarui.');
        })
        .catch(function(error) {
            console.error("Ada kesalahan saat memperbarui status:", error);
        });
    }


</script>
@endsection