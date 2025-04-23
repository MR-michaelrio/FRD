<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-transform: capitalize;
    }
    .container {
        margin: 20px;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    table{
        width:100%;
    }
    td{
        padding-left:5px;
    }
    </style>
</head>

<body>
    <div class="container">
        @php
            $no = 1;
        @endphp
        <table style="border:0px; margin-bottom:10px;">
            <tr style="border:0px">
                <td style="width:100px;border:0px"><img src="img/frd-logo.jpg" alt="" srcset="" width="100px"></td>
                <td style="border:0px"><h1>Indonesia Emergency Responder <span style="text-transform: uppercase;">{{$absen->wilayah}}</span></h1></td>
            </td>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan=3>Tanggal Absen {{ \Carbon\Carbon::parse($absen->tanggal_absen)->format('d-m-Y') }}</th>
                </tr>
                <tr>
                    <th style="width: 20px">#</th>
                    <th>Nama</th>
                    <th>Kehadiran</th>
                </tr>
            </thead>
            @foreach($data as $d)
            <tbody>
                <tr>
                    <td style="text-align:center">{{$no++}}</td>
                    <td>{{ $d->anggota->nama }} - {{ $d->anggota->Lembaga->nama_lembaga }}</td>
                    <td>
                        {{ $d->absenshadir }}
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <h3>Catatan: <p>{{ $absen->catatan }}</p></h3>
    </div>
</body>

</html>