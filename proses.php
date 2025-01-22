<?php 
include "koneksi.php";

if($_GET['proses']=="anggota"){
    $nama = $_POST['nama'];
    $lembaga = $_POST['lembaga'];
    $email = $_POST['email'];
    $no_pemegang = $_POST['no_pemegang'];
    $alamat = $_POST['alamat'];
    $no_darurat1 = $_POST['no_darurat1'];
    $nama_darurat1 = $_POST['nama_darurat1'];
    $no_darurat2 = $_POST['no_darurat2'];
    $nama_darurat2 = $_POST['nama_darurat2'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_regu = 4;
    $created_at = date('Y-m-d H:i:s');
        
    $stmt = $conn->prepare("INSERT INTO anggota (nama, lembaga, email, alamat, no_pemegang, no_darurat1, nama_darurat1, no_darurat2, nama_darurat2, tanggal_lahir, jenis_kelamin, id_regu, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
        
    if (!$stmt->bind_param("sssssssssssiss", $nama, $lembaga, $email, $alamat, $no_pemegang, $no_darurat1, $nama_darurat1, $no_darurat2, $nama_darurat2, $tanggal_lahir, $jenis_kelamin, $id_regu, $created_at, $created_at)) {
        die("Binding parameters failed: " . $stmt->error);
    }
        
    if ($stmt->execute()) {
        echo "<script>
                alert('Data inserted successfully!');
                window.location.href = 'index.php';
             </script>";
    } else {
        die("Execute failed: " . $stmt->error);
    }
    
        
    $stmt->close();
    $conn->close();

}
elseif($_GET['proses']=="edit"){
        $id_anggota = $_GET['id_anggota'];
        $nama = $_POST['nama'];
        $lembaga = $_POST['lembaga'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];
        $no_pemegang = $_POST['no_pemegang'];
        $no_darurat1 = $_POST['no_darurat1'];
        $nama_darurat1 = $_POST['nama_darurat1'];
        $no_darurat2 = $_POST['no_darurat2'];
        $nama_darurat2 = $_POST['nama_darurat2'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];

        $stmt = $conn->prepare("UPDATE anggota SET nama = ?, lembaga = ?, email = ?, alamat = ?, no_pemegang = ?, no_darurat1 = ?, nama_darurat1 = ?, no_darurat2 = ?, nama_darurat2 = ?, tanggal_lahir = ?, jenis_kelamin = ? WHERE id_anggota = ?");
        $stmt->bind_param('sssssssssssi', $nama, $lembaga, $email, $alamat, $no_pemegang, $no_darurat1, $nama_darurat1, $no_darurat2, $nama_darurat2, $tanggal_lahir, $jenis_kelamin, $id_anggota);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: table.php');
        exit;
}elseif($_GET['proses']=="delete"){
    $id_anggota = $_GET['id_anggota'];

    $sql = "DELETE FROM anggota WHERE id_anggota=$id_anggota";
    $result = mysqli_query($conn, $sql);

    header('Location: table.php');
    exit;
}

?>
