<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Pemegang Radio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 900px;
            width: 100%;
            margin: auto;
        }
        .logo-container img {
            max-width: 100%;
            height: auto;
        }
        @media (max-width: 768px) {
            .logo-container {
                text-align: center;
                margin-bottom: 15px;
            }
            .logo-container img {
                max-width: 200px;
            }
        }
    </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
    <div class="container p-4 bg-white rounded shadow-lg form-container">
        <div class="row align-items-center">
            <div class="col-md-4 logo-container text-center">
                <img src="{{asset('img/logo-04.jpg')}}" alt="Logo Lembaga" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h2 class="h4 text-center">Form Registrasi Pemegang Radio</h2>
                <form>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemegang Radio</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Tlp Pemegang Radio</label>
                            <input type="tel" class="form-control" required>
                        </div>
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
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">No Tlp Darurat</label>
                            <input type="tel" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemegang Telp Darurat 1</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">No Tlp Darurat 2</label>
                            <input type="tel" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemegang No Tlp Darurat 2</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
            </div>
        </div>
        <div class="alert alert-warning mt-3 text-center" role="alert">
            <strong>Catatan!</strong> Pastikan menu <i>Location Radio</i> selalu dinyalakan agar terekam di server jika terjadi sesuatu. Kami selaku admin bisa mengecek lokasi radio terakhir dan menginfokan anggota lain untuk memberikan bantuan jika terjadi kedaruratan. (Kerahasiaan database kami simpan secara private dan aman.)
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>