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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($wilayah as $w)
                    <tr class="clickable-row" data-id="{{ $w->id_wilayah }}" data-supervisor="{{ $w->supervisor }}">
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ $w->supervisor }}</td>
                        <td id="status-{{ $w->id_wilayah }}">
                            @if($w->status == 'menunggu persetujuan')
                                <button class="btn btn-warning btn-sm" disabled>Menunggu Persetujuan</button>
                            @elseif($w->status == 'disetujui')
                                <button class="btn btn-success btn-sm" disabled>Disetujui</button>
                            @elseif($w->status == 'ditolak')
                                <button class="btn btn-danger btn-sm" disabled>Ditolak</button>
                            @endif
                        </td>
                        <td>
                            <div class="status-buttons" data-id="{{ $w->id_wilayah }}">
                                <!-- Tombol untuk Menunggu Persetujuan -->
                                @if($w->status == 'menunggu persetujuan')
                                    <button class="btn btn-success btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'disetujui')">Disetujui</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'ditolak')">Ditolak</button>
                                @elseif($w->status == 'disetujui')
                                    <button class="btn btn-warning btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'menunggu persetujuan')">Menunggu Persetujuan</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'ditolak')">Ditolak</button>
                                @elseif($w->status == 'ditolak')
                                    <button class="btn btn-warning btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'menunggu persetujuan')">Menunggu Persetujuan</button>
                                    <button class="btn btn-success btn-sm" onclick="updateStatus({{ $w->id_wilayah }}, 'disetujui')">Disetujui</button>
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

<!-- Modal Edit Supervisor -->
<div class="modal fade" id="editSupervisorModal" tabindex="-1" role="dialog" aria-labelledby="editSupervisorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupervisorModalLabel">Edit Supervisor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSupervisorForm">
                    <input type="hidden" id="id_wilayah" name="id_wilayah">
                    <div class="form-group">
                        <label for="supervisor">Supervisor</label>
                        <select id="supervisor" name="supervisor" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id_anggota }}">{{ $supervisor->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('.select2').select2();

    // Klik pada <tr> untuk membuka modal
    $('.clickable-row').click(function() {
        let idWilayah = $(this).data('id');
        let supervisor = $(this).data('supervisor');

        // Set nilai ke modal
        $('#id_wilayah').val(idWilayah);
        $('#supervisor').val(supervisor).trigger('change');

        // Tampilkan modal
        $('#editSupervisorModal').modal('show');
    });
});
</script>


<script>
function updateStatus(wilayahId, newStatus) {
    // Buat data untuk dikirim    
    // Kirim request dengan fetch
    fetch(`/wilayah/${wilayahId}`, {
        method: 'PUT',
        body: JSON.stringify({ status: newStatus }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        // Periksa jika status response tidak ok (misalnya 400, 500, dll)
        if (!response.ok) {
            return response.json().then(errorData => {
                // Jika ada error, lempar error tersebut
                throw new Error(errorData.message || 'Terjadi kesalahan di server');
            });
        }
        return response.json();  // Jika berhasil, lanjutkan ke .then() berikutnya
    })
    .then(data => {
        if (data.success) {
            // Jika sukses, update tombol
            updateButtonVisibility(wilayahId, newStatus);
            updateStatusLabel(wilayahId, newStatus);
            alert('Status berhasil diperbarui.');
        } else {
            console.log(data);
            alert('Terjadi kesalahan.');
        }
    })
    .catch(error => {
        // Tangani error baik dari fetch maupun dari server
        console.error('Error:', error.message || error);
        alert(`Terjadi kesalahan: ${error.message || error}`);
    });
}


function updateButtonVisibility(wilayahId, newStatus) {
    const buttonsContainer = document.querySelector(`.status-buttons[data-id="${wilayahId}"]`);
    
    // Sembunyikan tombol berdasarkan status baru
    buttonsContainer.innerHTML = '';

    if (newStatus === 'menunggu persetujuan') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-success btn-sm" onclick="updateStatus(${wilayahId}, 'disetujui')">Disetujui</button>
            <button class="btn btn-danger btn-sm" onclick="updateStatus(${wilayahId}, 'ditolak')">Ditolak</button>
        `;
    } else if (newStatus === 'disetujui') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-warning btn-sm" onclick="updateStatus(${wilayahId}, 'menunggu persetujuan')">Menunggu Persetujuan</button>
            <button class="btn btn-danger btn-sm" onclick="updateStatus(${wilayahId}, 'ditolak')">Ditolak</button>
        `;
    } else if (newStatus === 'ditolak') {
        buttonsContainer.innerHTML = `
            <button class="btn btn-warning btn-sm" onclick="updateStatus(${wilayahId}, 'menunggu persetujuan')">Menunggu Persetujuan</button>
            <button class="btn btn-success btn-sm" onclick="updateStatus(${wilayahId}, 'disetujui')">Disetujui</button>
        `;
    }
}

function updateStatusLabel(wilayahId, newStatus) {
    const statusColumn = document.querySelector(`#status-${wilayahId}`);

    if (newStatus === 'menunggu persetujuan') {
        statusColumn.innerHTML = `<button class="btn btn-warning btn-sm" disabled>Menunggu Persetujuan</button>`;
    } else if (newStatus === 'disetujui') {
        statusColumn.innerHTML = `<button class="btn btn-success btn-sm" disabled>Disetujui</button>`;
    } else if (newStatus === 'ditolak') {
        statusColumn.innerHTML = `<button class="btn btn-danger btn-sm" disabled>Ditolak</button>`;
    }
}
</script>
</script>
@endsection