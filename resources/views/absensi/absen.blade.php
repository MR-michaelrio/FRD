<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Bootstrap-datepicker CSS and JavaScript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <title>LAPORAN KESIAPSIAGAAN Indonesia Emergency Responder</title>
    <style>
    .card-header {
        font-size: 30px;
    }

    .formlabel1,
    .btn {
        font-size: 25px;
    }

    input,
    .form-check-label,
    .formlabel2 {
        font-size: 20px;
    }

    .form-check-input,
    .form-control {
        border: 1px solid black;
    }

    /* Responsive font sizes using rem units */
    @media (max-width: 768px) {
        .card-header {
            font-size: 25px;
        }

        .formlabel1,
        .btn {
            font-size: 20px;
            /* 14px */
        }

        .input,
        .form-check-label,
        .formlabel2 {
            font-size: 15px;
        }
    }

    @media (max-width: 576px) {

        .formlabel1,
        .btn {
            font-size: 15px;
            /* 12px */
        }

        .input,
        .form-check-label,
        .formlabel2 {
            font-size: 15px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h5 class="card-header">LAPORAN ABSENSI Indonesia Emergency Responder <span style="text-transform: uppercase;">{{$namawilayah->nama_wilayah}}</span></h5>
            <form action="{{ route('absen.store2')}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label formlabel1">Tanggal Absen Malam ?<span
                                style="color: red;">*</span></label>
                        <div>
                            <div>
                                <label for="datepicker">Tanggal</label>
                                <input type="text" id="datepicker" placeholder="dd/mm/yyyy" name="tanggal_absen"
                                    class="form-control" autocomplete="off" required>
                                    
                                <input type="hidden" name="wilayah" value="{{$id}}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label formlabel1">Regu Yang Berjaga ?<span
                                style="color: red;">*</span></label>
                        @foreach($anggota as $agt)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" required name="petugas" value="{{ $agt->id_anggota }}"
                                id="{{ $agt->id_anggota }}1">
                            <label class="form-check-label" for="{{ $agt->id_anggota }}1">
                                {{ $agt->nama }} - {{ $agt->Regu->nama_regu}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <hr style="border-top: 3px solid black;">
                    @foreach($ag as $a)
                    <div class="mb-3">
                        <label class="form-label formlabel1">R - {{ $a->nama }} - {{ $a->Lembaga->nama_lembaga }}<span
                                style="color: red;">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="absenshadir[{{ $a->id_anggota }}]"
                                value="hadir"  id="{{ $a->id_anggota }}">
                            <label class="form-check-label" for="{{ $a->id_anggota }}">
                                Hadir
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="absenshadir[{{ $a->id_anggota }}]"
                                value="tidak"  id="{{ $a->id_anggota }}2">
                            <label class="form-check-label" for="{{ $a->id_anggota }}2">
                                Tidak Hadir
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="absenshadir[{{ $a->id_anggota }}]"
                                value="lain"  id="lain-{{ $a->id_anggota }}">
                            <label class="form-check-label" for="lain-{{ $a->id_anggota }}">
                                Lain
                            </label>
                        </div>
                        <div class="form-group lainInput" id="lainInput-{{ $a->id_anggota }}" style="display: none;">
                            <label for="lainText-{{ $a->id_anggota }}">Lain Text:</label>
                            <input type="text" id="lainText-{{ $a->id_anggota }}" name="lainText[{{ $a->id_anggota }}]"
                                class="form-control">
                        </div>
                    </div>
                    <hr style="border-top: 3px solid black;">
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label formlabel1">Catatan<span style="color: red;">*</span></label>
                        <label for="">Jangan lupa memberikan kesempatan bagi yang terlewat atau yang belum memberikan lombok pati malam</label>
                        <textarea name="catatan" id="" rows="5" class="form-control" required></textarea>
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
    // Initialize datepicker
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    // Set current date in the datepicker field
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    
    // Adjust format to 'yyyy-mm-dd'
    var formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
    // Set the formatted date to the input field
    $('#datepicker').val(formattedDate);

    // Function to show/hide 'Lain' input based on radio button selection
    $('input[type=radio][value="lain"]').change(function() {
        var id = $(this).attr('id').split('-')[1];
        if ($(this).is(':checked')) {
            $('#lainInput-' + id).show();
        } else {
            $('#lainInput-' + id).hide();
        }
    });

    // Initial check to show/hide based on the initial radio button values
    $('input[type=radio][value="lain"]:checked').each(function() {
        var id = $(this).attr('id').split('-')[1];
        $('#lainInput-' + id).show();
    });
});
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>