@extends('template.master')

@section('title')
    Wilayah
@endsection

@section('css')
    <style>
        /* Kustom tombol untuk status */
.status-btn {
    padding: 5px 15px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    color: white;
    font-weight: bold;
}

.status-btn.yellow {
    background-color: #ffc107; /* Kuning */
}

.status-btn.green {
    background-color: #28a745; /* Hijau */
}

.status-btn.red {
    background-color: #dc3545; /* Merah */
}

.status-btn:hover {
    opacity: 0.8;
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
                        <td>
                            <div class="status-box" data-id="{{ $w->id }}">
                                <button class="status-btn @if($w->status == 'menunggu persetujuan') yellow @elseif($w->status == 'disetujui') green @elseif($w->status == 'ditolak') red @endif" onclick="changeStatus(this)">
                                    {{ ucfirst($w->status) }}
                                </button>
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
    function changeStatus(button) {
    const currentStatus = button.textContent.trim().toLowerCase();
    const wilayahId = button.closest('div').getAttribute('data-id');

    // Menentukan status baru berdasarkan status saat ini
    let newStatus = '';
    if (currentStatus === 'menunggu persetujuan') {
        newStatus = 'disetujui';
    } else if (currentStatus === 'disetujui') {
        newStatus = 'ditolak';
    } else {
        newStatus = 'menunggu persetujuan';
    }

    // Mengirim request untuk memperbarui status ke server
    axios.post('/update-status-wilayah', {
        wilayah_id: wilayahId,
        status: newStatus
    })
    .then(function(response) {
        // Memperbarui tombol berdasarkan status yang baru
        button.textContent = ucfirst(newStatus);

        // Memperbarui warna tombol sesuai status baru
        button.className = 'status-btn ' + (newStatus === 'menunggu persetujuan' ? 'yellow' : newStatus === 'disetujui' ? 'green' : 'red');
    })
    .catch(function(error) {
        console.error("Ada kesalahan saat memperbarui status:", error);
    });
}

// Fungsi untuk kapitalisasi pertama huruf
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>
@endsection