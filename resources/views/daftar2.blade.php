<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Pemegang Radio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container p-4 bg-white rounded shadow-lg" style="max-width: 500px;">
        <header class="text-center mb-3">
            <img src="logo.png" alt="Logo Lembaga" class="mb-2" style="max-width: 80px;">
            <h2 class="h4">Form Registrasi Pemegang Radio</h2>
        </header>
        <form>
            <div class="mb-2">
                <label class="form-label">Nama Pemegang Radio</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Nama Lembaga</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">No Tlp Pemegang Radio</label>
                <input type="tel" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Alamat</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">No Tlp Darurat</label>
                <input type="tel" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Nama Pemegang Telp Darurat 1</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">No Tlp Darurat 2</label>
                <input type="tel" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">Nama Pemegang No Tlp Darurat 2</label>
                <input type="text" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <div class="alert alert-warning mt-3 text-center" role="alert">
            <strong>Catatan!</strong> Pastikan menu <i>Location Radio</i> selalu dinyalakan agar terekam di server jika terjadi sesuatu. Kami selaku admin bisa mengecek lokasi radio terakhir dan menginfokan anggota lain untuk memberikan bantuan jika terjadi kedaruratan. (Kerahasiaan database kami simpan secara private dan aman.)
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
