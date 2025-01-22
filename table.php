<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        th{
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Pemegang Radio</th>
                    <th scope="col">Lembaga</th>
                    <th scope="col">Email</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No Tlp Pemegang Radio</th>
                    <th scope="col">No Darurat 1</th>
                    <th scope="col">Nama Darurat 1</th>
                    <th scope="col">No Darurat 2</th>
                    <th scope="col">Nama Darurat 2</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "koneksi.php";
                    $no = 1;
                    $data = mysqli_query($conn,"SELECT * FROM anggota");
                    $jmlh = mysqli_query($conn,"SELECT COUNT(*) as Jumlah FROM anggota");
                    $result = mysqli_fetch_assoc($jmlh);
                    $count = $result['Jumlah'];
                    if($count > 0){
                    foreach($data as $p) :
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $p['nama'] ?></td>
                        <td><?= $p['lembaga'] ?></td>
                        <td><?= $p['email'] ?></td>
                        <td><?= $p['alamat'] ?></td>
                        <td><?= $p['no_pemegang'] ?></td>
                        <td><?= $p['no_darurat1'] ?></td>
                        <td><?= $p['nama_darurat1'] ?></td>
                        <td><?= $p['no_darurat2'] ?></td>
                        <td><?= $p['nama_darurat2'] ?></td>
                        <td><?= $p['tanggal_lahir'] ?></td>
                        <td><?= $p['jenis_kelamin'] ?></td>
                        <td>
                            <a href="update.php?id_anggota=<?= $p['id_anggota'] ?>" class="btn btn-warning">Update</a>
                        </td>
                        <td><a href="proses.php?proses=delete&id_anggota=<?= $p['id_anggota'] ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus Data?')">Delete</a></td>
                    </tr>
                <?php endforeach; }else{ echo"<td colspan='6'></td>"; }?>
            </tbody>
        </table>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>