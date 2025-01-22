<?php
include "koneksi.php";
$id = $_GET['id_anggota'];
$sql = "SELECT * FROM anggota WHERE id_anggota=$id";
$result = mysqli_query($conn, $sql);
$obj = mysqli_fetch_object($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Form Pendaftaran Anggota Forum Radio Digital</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
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
    </style>
  </head>  
  <body>
    <div class="testbox">
      <form action="proses.php?proses=edit&id_anggota=<?= $obj->id_anggota ?>" id="myForm" method="post">
        <div class="banner">
          <!-- <h1>Form Pendaftaran Anggota Forum Radio Digital </h1> -->
          <img src="img/frd-logo.jpg" alt="" srcset="">
        </div>
        <p class="dp">Data Pribadi</p>
        <div class="item">
          <label for="name">Nama Pemegang Radio<span>*</span></label>
          <input id="name" type="text" name="nama" value="<?= $obj->nama ?>" required/>
        </div>
        <div class="item">
          <label for="name">Nama Lembaga<span>*</span></label>
          <input id="name" type="text" name="lembaga" value="<?= $obj->lembaga ?>" required/>
        </div>
        <div class="item">
          <label for="email">Email<span>*</span></label>
          <input id="email" type="email" name="email" value="<?= $obj->email ?>" required/>
        </div>
        <div class="item">
          <label for="city">No tlp Pemepang Radio<span>*</span></label>
          <input id="city" type="text" name="no_pemegang" value="<?= $obj->no_pemegang ?>" required/>
        </div>
        <div class="item">
          <label for="address">Alamat<span>*</span></label>
          <input id="address" type="address" name="alamat" value="<?= $obj->alamat ?>" required/>
        </div>
        <div class="item">
          <label for="city">No telp Darurat<span>*</span></label>
          <input id="city" type="text" name="no_darurat1" value="<?= $obj->no_darurat1 ?>" required/>
        </div>
        <div class="item">
          <label for="state">Nama Pemegang Telp Darurat 1<span>*</span></label>
          <input id="state" type="text" name="nama_darurat1" value="<?= $obj->nama_darurat1 ?>" required/>
        </div>
        <div class="item">
          <label for="zip">No Telp Darurat 2<span>*</span></label>
          <input id="zip" type="text" name="no_darurat2" value="<?= $obj->no_darurat2 ?>" required/>
        </div>
        <div class="item">
          <label for="phone">Nama Pemegang No Telp Darurat 2<span>*</span></label>
          <input id="phone" type="text" name="nama_darurat2" value="<?= $obj->nama_darurat2 ?>" required/>
        </div>
        <div class="item">
          <label for="bdate">Tanggal Lahir<span>*</span></label>
          <input type="text" id="dateInput" name="tanggal_lahir" value="<?= $obj->tanggal_lahir ?>" placeholder="dd/mm/yyyy">
        </div>
        <div class="question">
          <label class="jk">Jenis Kelamin</label>
          <div class="question-answer">
            <div>
              <input type="radio" value="Laki-laki" id="radio_1" <?php if($obj->jenis_kelamin == "Laki-laki"){echo"checked";} ?> name="jenis_kelamin"/>
              <label for="radio_1" class="radio"><span>Laki Laki</span></label>
            </div>
            <div>
              <input  type="radio" value="Perempuan" id="radio_2" <?php if($obj->jenis_kelamin == "Perempuan"){echo"checked";} ?> name="jenis_kelamin"/>
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
    </script>
  </body>
</html>