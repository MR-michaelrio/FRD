<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indonesian Emergency Responder - Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            max-width: 900px;
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
<body class="bg-light">
    <div class="form-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row align-items-center">
            <div class="col-md-4 logo-container text-center">
                <img src="{{ asset('img/logo-04.jpg') }}" alt="Logo Lembaga" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h2 class="h4 text-center">Ganti Password</h2>
                <form action="{{ route('update.password') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Password Lama</label>
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password Baru</label>
                        <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
