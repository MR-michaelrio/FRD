<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Form Pendaftaran Anggota Forum Radio Digital</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        html,
        body {
            min-height: 100%;
        }

        body,
        div,
        form,
        input,
        select,
        textarea,
        label {
            padding: 0;
            margin: 0;
            outline: none;
            font-family: Roboto, Arial, sans-serif;
            font-size: 14px;
            color: #666;
            line-height: 22px;
        }

        h1 {
            position: absolute;
            margin: 0;
            font-size: 40px;
            color: #fff;
            z-index: 2;
            line-height: 83px;
        }

        .testbox {
            display: flex;
            justify-content: center;
            align-items: center;
            height: inherit;
            padding: 20px;
        }

        form {
            width: 100%;
            padding: 20px;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 0 8px #cc7a00;
        }

        .dp {
            font-size: 30px;
        }

        .testbox .banner {
            position: relative;
            height: 300px;
            background-image: url("Foto.jpg");
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .banner::after {
            content: "";
            background-color: rgba(0, 0, 0, 0.2);
            position: absolute;
            width: 100%;
            height: 100%;
        }

        input,
        select,
        textarea {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input {
            width: calc(100% - 10px);
            padding: 5px;
        }

        input[type="date"] {
            padding: 4px 5px;
        }

        textarea {
            width: calc(100% - 12px);
            padding: 5px;
        }

        .item:hover p,
        .item:hover i,
        .question:hover p,
        .question label:hover,
        input:hover::placeholder {
            color: #cc7a00;
        }

        .item input:hover,
        .item select:hover,
        .item textarea:hover {
            border: 1px solid transparent;
            box-shadow: 0 0 3px 0 #cc7a00;
            color: #cc7a00;
        }

        .item {
            position: relative;
            margin: 10px 0;
        }

        .item span {
            color: red;
        }

        .item i {
            right: 1%;
            top: 30px;
            z-index: 1;
        }

        input[type=radio],
        input[type=checkbox] {
            display: none;
        }

        label.radio {
            position: relative;
            display: inline-block;
            margin: 5px 20px 15px 0;
            cursor: pointer;
        }

        .question span {
            margin-left: 30px;
        }

        .question-answer label {
            display: block;
        }

        label.radio:before {
            content: "";
            position: absolute;
            left: 0;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        input[type=radio]:checked+label:before,
        label.radio:hover:before {
            border: 2px solid #cc7a00;
        }

        label.radio:after {
            content: "";
            position: absolute;
            top: 6px;
            left: 5px;
            width: 8px;
            height: 4px;
            border: 3px solid #cc7a00;
            border-top: none;
            border-right: none;
            transform: rotate(-45deg);
            opacity: 0;
        }

        input[type=radio]:checked+label:after {
            opacity: 1;
        }

        .btn-block {
            margin-top: 10px;
            text-align: center;
        }

        button {
            width: 150px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #cc7a00;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background: #ff9800;
        }

        @media (min-width: 568px) {

            .name-item,
            .city-item {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .name-item input,
            .name-item div {
                width: calc(50% - 20px);
            }

            .name-item div input {
                width: 97%;
            }

            .name-item div label {
                display: block;
                padding-bottom: 5px;
            }

            .danger {
                background-color: #ffdddd;
                border-left: 6px solid #f44336;
            }

            label {
                font-size: x-large;
            }

            #bdate {
                font-size: x-large;
            }

            .jk {
                font-size: small;
            }

            label.radio {
                font-size: small;
            }

            .danger {
                font-size: smaller;
            }
        }
        .banner{
            background-color: black;
        }
        .jk{
            font-size:25px;
        }
        label.radio {
            font-size: large;
        }
        img{
            width:auto;
            max-height:300px;
            background-repeat: no-repeat;
        }
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            display: none; /* Initially hidden */
        }

        /* Success Alert */
        .alert-success {
            background-color: #4caf50; /* Green background */
            color: white; /* White text */
            border: 1px solid #388e3c; /* Darker green border */
        }

        /* Error Alert */
        .alert-error {
            background-color: #f44336; /* Red background */
            color: white; /* White text */
            border: 1px solid #d32f2f; /* Darker red border */
        }

        /* Information Alert */
        .alert-info {
            background-color: #2196f3; /* Blue background */
            color: white; /* White text */
            border: 1px solid #1976d2; /* Darker blue border */
        }

        /* Close button */
        .alert .close-btn {
            color: white;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            float: right;
            margin-left: 10px;
        }
    </style>
  </head>  
  <body>
    @if(session('success'))
        <div class="alert alert-success">
            <span>{{ session('success') }}</span>
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif
    <div class="testbox">
      <form action="{{ route('anggota.daftar') }}" id="myForm" method="post">
        @csrf
        <div class="banner">
          <!-- <h1>Form Pendaftaran Anggota Forum Radio Digital </h1> -->
          <img src="{{asset('img/frd-logo.jpg')}}" alt="" srcset="">
        </div>
        <p class="dp">Data Pribadi</p>
        <div class="item">
          <label for="name">Nama Pemegang Radio<span>*</span></label>
          <input id="name" type="text" name="nama" required/>
        </div>
        <div class="item">
          <label for="name">Nama Lembaga<span>*</span></label>
          <input id="name" type="text" name="lembaga" required/>
        </div>
        <div class="item">
          <label for="email">Email<span>*</span></label>
          <input id="email" type="email" name="email" required/>
        </div>
        <div class="item">
          <label for="city">No tlp Pemepang Radio<span>*</span></label>
          <input id="city" type="text" name="no_pemegang" required/>
        </div>
        <div class="item">
          <label for="address">Alamat<span>*</span></label>
          <input id="address" type="address" name="alamat" required/>
        </div>
        <div class="item">
          <label for="city">No telp Darurat<span>*</span></label>
          <input id="city" type="text" name="no_darurat1" required/>
        </div>
        <div class="item">
          <label for="state">Nama Pemegang Telp Darurat 1<span>*</span></label>
          <input id="state" type="text" name="nama_darurat1" required/>
        </div>
        <div class="item">
          <label for="zip">No Telp Darurat 2<span>*</span></label>
          <input id="zip" type="text" name="no_darurat2" required/>
        </div>
        <div class="item">
          <label for="phone">Nama Pemegang No Telp Darurat 2<span>*</span></label>
          <input id="phone" type="text" name="nama_darurat2" required/>
        </div>
        <div class="item">
          <label for="bdate">Tanggal Lahir<span>*</span></label>
          <input type="text" id="dateInput" name="tanggal_lahir" placeholder="dd/mm/yyyy">
        </div>
        <div class="question">
          <label class="jk">Jenis Kelamin</label>
          <div class="question-answer">
            <div>
              <input type="radio" value="Laki-laki" id="radio_1" name="jenis_kelamin"/>
              <label for="radio_1" class="radio"><span>Laki Laki</span></label>
            </div>
            <div>
              <input  type="radio" value="Perempuan" id="radio_2" name="jenis_kelamin"/>
              <label for="radio_2" class="radio"><span>Perempuan</span></label>
            </div>
          </div>
        </div>
        <div class="danger">
          <p><strong>Catatan!</strong> Pastikan menu <i>Location Radio</i> untuk selalu di nyalakan agar terekam di server jika terjadi sesuatu hal kami selaku admin bisa mengecek keberadaan lokasi radio terakhir dan bisa menginfokan anggota yang lain agar bisa memberikan bantuan jika terjadi kedaruratan (kerahasiaan database kami simpan secara private dan aman di dalam server agar tidak dibuka oleh orang lain.</p>
        </div>
        <div class="btn-block">
          <button type="submit">SUBMIT</button>
        </div>
      </form>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr('#dateInput', {
            dateFormat: 'd/m/Y',
            allowInput: true,
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide success alert after 5 seconds
            setTimeout(function () {
                let alert = document.querySelector('.alert-success');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 5000); // 5000ms = 5 seconds
        });

    </script>
  </body>
</html>