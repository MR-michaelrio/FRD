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
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ $w->supervisor ?? 'Tidak Ada' }}</a>
                        </td>
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
                        <td>
                            <button class="btn btn-info btn-sm" onclick="openUpdateModal({{ $w->id_wilayah }}, '{{ $w->nama_wilayah }}', {{ $w->supervisor_id ?? 'null' }})">Update</button>
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

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Wilayah</h5>
      </div>
      <form id="updateForm">

      <div class="modal-body">
          <div class="mb-3">
            <label for="namaWilayah" class="form-label">Nama Wilayah</label>
            <input type="text" class="form-control" id="namaWilayah" name="nama_wilayah" required>
            <input type="text" class="form-control" id="idWilayah" name="id_wilayah" required>
          </div>
          <div class="mb-3">
            <label for="supervisorSelect" class="form-label">Supervisor</label>
            <select class="form-control select2" id="supervisorSelect" name="supervisor" style="width: 100%;">
                <option value="0" selected>Pilih Supervisor</option>
                @foreach($supervisors as $d)
                    <option value="{{$d->id_anggota}}">{{$d->id_anggota}}-{{$d->nama}}</option>
                @endforeach
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveChangesButton">Save changes</button>
      </div>
      </form>

    </div>
  </div>
</div>

<script>
  // Fungsi untuk membuka modal update
  function openUpdateModal(idWilayah, namaWilayah, supervisorId) {
    // Isi form dengan data yang sudah ada
    document.getElementById('idWilayah').value = idWilayah;

    document.getElementById('namaWilayah').value = namaWilayah;
    if (supervisorId !== null) {
      document.getElementById('supervisorSelect').value = supervisorId;
    } else {
      document.getElementById('supervisorSelect').value = '';
    }

    // Simpan ID wilayah untuk nanti digunakan saat simpan perubahan
    $('#saveChangesButton').attr('onclick', `saveUpdate(${idWilayah})`);

    // Buka modal
    $('#updateModal').modal('show');
  }

  // Fungsi untuk menyimpan perubahan
  // Fungsi untuk menyimpan perubahan
    document.getElementById('updateForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah form submit otomatis

        // Mengambil nilai input dari form
        var idWilayah = document.getElementById('idWilayah').value;

        var namaWilayah = document.getElementById('namaWilayah').value;
        var supervisor = document.getElementById('supervisorSelect').value;

        // Membuat objek data untuk dikirim
        var data = {
            nama_wilayah: namaWilayah,
            supervisor: supervisor
        };

        // Mengirim data menggunakan fetch
        fetch('/wilayah/' + idWilayah, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(data), // Mengonversi data menjadi format JSON
        })
        .then(response => response.json()) // Mengonversi response ke JSON
        .then(data => {
            if (data.success) {
                alert('Data berhasil diperbarui!');
                location.reload(); // Reload halaman untuk melihat perubahan
            } else {
                alert('Gagal memperbarui data.');
            }
        })
        .catch(error => {
            console.error('Terjadi kesalahan:', error);
            alert('Terjadi kesalahan, coba lagi!');
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
@endsection