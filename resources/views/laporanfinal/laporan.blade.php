<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Bootstrap-datepicker CSS and JavaScript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <title>LAPORAN KESIAPSIAGAAN Indonesia Emergency Responder</title>
    <style>
        .card-header{
            font-size: 30px;
        }
        .formlabel1,.btn{
            font-size: 25px;
        }
        input,.form-check-label,.formlabel2{
            font-size: 20px;
        }
        .form-check-input,.form-control{
            border: 1px solid black;
        }
        .waktujam{
            display: flex;
            width: 100%;
        }
        /* Responsive font sizes using rem units */
        @media (max-width: 768px) {
            .card-header{
                font-size: 25px;
            }
            .formlabel1,.btn {
                font-size: 20px; /* 14px */
            }
            .input,.form-check-label,.formlabel2{
                font-size: 15px;
            }
        }

        @media (max-width: 576px) {
            .formlabel1,.btn {
                font-size: 15px; /* 12px */
            }
            .input,.form-check-label,.formlabel2{
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h5 class="card-header">LAPORAN KESIAPSIAGAAN Indonesia Emergency Responder</h5>
            <form action="{{route('laporan.store')}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label formlabel1">Tanggal Selesai Piket ?<span style="color: red;">*</span></label>
                        <div class="waktujam">
                            <div style="width: 70%; margin-right: 10px;">
                            <label for="datepicker">Tanggal</label>
                            <input type="text" name="tanggal" id="datepicker" placeholder="dd/mm/yyyy" class="form-control" autocomplete="off" required>
                            </div>
                            <div style="width: 50%;">
                                <label for="time">Waktu</label>
                                <div style="display: flex;">
                                <input type="text" id="time" placeholder="jam" name="jam" class="form-control" style="width: 50%;" required>
                                <input type="text" id="time" placeholder="menit" name="menit" class="form-control" style="width: 50%;" required>
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <div class="mb-3">
                        <label class="form-label formlabel1">Nama Pengisi Form ?<span style="color: red;">*</span></label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label formlabel1">Regu Yang Berjaga ?<span style="color: red;">*</span></label>
                        @foreach($regu as $r)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="regu" value="{{ $r->nama_regu }}" id="regu{{ $r->id_regu }}">
                            <label class="form-check-label" for="regu{{ $r->id_regu }}">
                                {{ $r->nama_regu }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label class="form-label formlabel1">
                            Petugas 102 ?
                            <span style="color: red;">*</span>
                            <br>
                            <span class="form-label formlabel2">Pilih Sesuai yang piket (contoh terbit dan dennis) maka centang kedua nama tersebut</span>
                        </label>
                        @foreach($anggota as $agt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="petugas_piket[]" value="{{$agt->nama}}" id="petugas{{$agt->id_anggota}}">
                            <label class="form-check-label" for="petugas{{$agt->id_anggota}}">
                                {{$agt->nama}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label class="form-label formlabel1">
                            Laporan kejadian menonjol pada saat piket ?
                            <span style="color: red;">*</span>
                            <br>
                            <span class="form-label formlabel2">silahkan diisi kejadian menonjol yang di naikan ke radio pada saat piket. jika tidak ada kejadian maka diisi tidak ada kejadian</span>
                        </label>
                        <!-- <input type="text" class="form-control" name="kejadian" required> -->
                        <textarea name="kejadian" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
