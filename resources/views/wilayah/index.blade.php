@extends('template.master')

@section('title')
    Wilayah
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
                        <select class="form-control" data-id="{{ $w->id }}" onchange="updateStatus(this)" id="status-{{ $w->id_wilayah }}">
    <option value="menunggu persetujuan" @if($w->status == 'menunggu persetujuan') selected @endif>Menunggu Persetujuan</option>
    <option value="disetujui" @if($w->status == 'disetujui') selected @endif>Disetujui</option>
    <option value="ditolak" @if($w->status == 'ditolak') selected @endif>Ditolak</option>
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
    // Fungsi untuk memperbarui status dan latar belakang pilihan
function updateStatus(select) {
    const status = select.value;
    const wilayahId = select.getAttribute('data-id');

    // Mengubah background setiap option sesuai dengan status
    const options = select.options;
    for (let i = 0; i < options.length; i++) {
        let option = options[i];
        if (option.value === 'menunggu persetujuan') {
            option.style.backgroundColor = '#ffc107'; // Kuning
        } else if (option.value === 'disetujui') {
            option.style.backgroundColor = '#28a745'; // Hijau
        } else if (option.value === 'ditolak') {
            option.style.backgroundColor = '#dc3545'; // Merah
        }
    }

    // Kirim request untuk update status
    axios.post('/update-status-wilayah', {
        wilayah_id: wilayahId,
        status: status
    })
    .then(function(response) {
        console.log('Status berhasil diperbarui.');
    })
    .catch(function(error) {
        console.error("Ada kesalahan saat memperbarui status:", error);
    });
}

// Inisialisasi warna pada halaman load
window.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select[data-id]');
    console.log("sel;ect",selects);
    selects.forEach(function(select) {
        const status = select.value;
        const options = select.options;
        for (let i = 0; i < options.length; i++) {
            let option = options[i];
            if (option.value === 'menunggu persetujuan') {
                option.style.backgroundColor = '#ffc107'; // Kuning
            } else if (option.value === 'disetujui') {
                option.style.backgroundColor = '#28a745'; // Hijau
            } else if (option.value === 'ditolak') {
                option.style.backgroundColor = '#dc3545'; // Merah
            }
        }
    });
});


</script>
@endsection