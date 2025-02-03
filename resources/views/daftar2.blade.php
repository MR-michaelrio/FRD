<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Pemegang Radio</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        header {
            margin-bottom: 20px;
        }
        header img {
            max-width: 100px;
            display: block;
            margin: 0 auto 10px;
        }
        h2 {
            font-size: 22px;
            color: #333;
        }
        label {
            font-size: 14px;
            font-weight: 600;
            color: #555;
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        .catatan {
            font-size: 12px;
            margin-top: 15px;
            background: #fff3cd;
            padding: 10px;
            border-radius: 8px;
            border-left: 5px solid #ffcc00;
            text-align: left;
        }
        button {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="{{asset('img/frd-logo.jpg')}}" alt="Logo Lembaga">
            <h2>Form Registrasi Pemegang Radio</h2>
        </header>
        <form>
            <label>Nama Pemegang Radio</label>
            <input type="text" required>
            
            <label>Nama Lembaga</label>
            <input type="text" required>
            
            <label>Email</label>
            <input type="email" required>
            
            <label>No Tlp Pemegang Radio</label>
            <input type="tel" required>
            
            <label>Alamat</label>
            <input type="text" required>
            
            <label>No Tlp Darurat</label>
            <input type="tel" required>
            
            <label>Nama Pemegang Telp Darurat 1</label>
            <input type="text" required>
            
            <label>No Tlp Darurat 2</label>
            <input type="tel">
            
            <label>Nama Pemegang No Tlp Darurat 2</label>
            <input type="text">
            
            <label>Tanggal Lahir</label>
            <input type="date" required>
            
            <label>Jenis Kelamin</label>
            <select required>
                <option value="">Pilih</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            
            <button type="submit">Daftar</button>
        </form>
        <div class="catatan">
            <p><strong>Catatan!</strong> Pastikan menu <i>Location Radio</i> selalu dinyalakan agar terekam di server jika terjadi sesuatu. Kami selaku admin bisa mengecek lokasi radio terakhir dan menginfokan anggota lain untuk memberikan bantuan jika terjadi kedaruratan. (Kerahasiaan database kami simpan secara private dan aman.)</p>
        </div>
    </div>
</body>
</html>