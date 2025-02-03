@extends('template.master')

@section('title')
    Wilayah
@endsection

@section('css')
<style>
.status-buttons .btn {
    margin-right: 5px;
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
                            <div class="status-buttons" data-id="{{ $w->id }}">
                                <!-- Tombol untuk Menunggu Persetujuan -->
                                @if($w->status == 'menunggu persetujuan')
                                    <button class="btn btn-success btn-sm" onclick="updateStatus(this, 'disetujui')">Disetujui</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus(this, 'ditolak')">Ditolak</button>
                                @elseif($w->status == 'disetujui')
                                    <button class="btn btn-warning btn-sm" onclick="updateStatus(this, 'menunggu persetujuan')">Menunggu Persetujuan</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus(this, 'ditolak')">Ditolak</button>
                                @elseif($w->status == 'ditolak')
                                    <button class="btn btn-warning btn-sm" onclick="updateStatus(this, 'menunggu persetujuan')">Menunggu Persetujuan</button>
                                    <button class="btn btn-success btn-sm" onclick="updateStatus(this, 'disetujui')">Disetujui</button>
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
<script>
function updateStatus(button, newStatus) {
    const wilayahId = button.closest('.status-buttons').getAttribute('data-id');

    // Kirim request untuk update status
    axios.post('/update-status-wilayah', {
        wilayah_id: wilayahId,
        status: newStatus
    })
    .then(function(response) {
        // Setelah status berhasil diperbarui, ubah tampilan tombol yang tersedia
        updateButtonVisibility(newStatus, wilayahId);
        console.log('Status berhasil diperbarui.');
    })
    .catch(function(error) {
        console.error("Ada kesalahan saat memperbarui status:", error);
    });
}

// Fungsi untuk memperbarui tombol berdasarkan status terbaru
function updateButtonVisibility(newStatus, wilayahId) {
    const buttonsContainer = document.querySelector(`.status-buttons[data-id="${wilayahId}"]`);
    
    // Sembunyikan tombol berdasarkan status baru
    buttonsContainer.innerHTML = '';

    if (newStatus === 'menunggu persetujuan') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-success btn-sm" onclick="updateStatus(this, 'disetujui')">Disetujui</button>
            <button class="btn btn-danger btn-sm" onclick="updateStatus(this, 'ditolak')">Ditolak</button>
        `;
    } else if (newStatus === 'disetujui') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-warning btn-sm" onclick="updateStatus(this, 'menunggu persetujuan')">Menunggu Persetujuan</button>
            <button class="btn btn-danger btn-sm" onclick="updateStatus(this, 'ditolak')">Ditolak</button>
        `;
    } else if (newStatus === 'ditolak') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-warning btn-sm" onclick="updateStatus(this, 'menunggu persetujuan')">Menunggu Persetujuan</button>
            <button class="btn btn-success btn-sm" onclick="updateStatus(this, 'disetujui')">Disetujui</button>
        `;
    }
}

</script>
@endsection