<?php 
$conn = mysqli_connect('localhost','root','','ukako');

if(isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $lokasi = $_POST['lokasi'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];

    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $lokasiFile = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    if($error===4){
        echo "<script>
            alert('Pilih gambar dahulu!');
            </script>";
        return false;
    }

    $extensiGambarValid=['jpg','png','webp','jpeg'];
    $extensiGambar=explode('.',$namaFile);
    $extensiGambar=strtolower(end($extensiGambar));
    if(!in_array($extensiGambar,$extensiGambarValid)){
        echo "<script>
            alert('File bukan gambar!');
            </script>";
        return false;
    }

    if($ukuranFile>7000000){
        echo "<script>
            alert('Size terlalu besar!');
            </script>";
        return false;
    }

    move_uploaded_file($lokasiFile,'img/'.$namaFile);
    $foto = 'img/'.$namaFile;


    $sql = "insert into laporan values (null, '$nama', '$kelas', '$lokasi', '$jenis', '$deskripsi', '$foto', 'menunggu')";
    $result = $conn->query($sql);

    if($result){
        echo "<script>
            alert('Laporan berhasil diajukan!');
            document.location.href = 'laporan.php';
            </script>";
    } else {
        echo "<script>
            alert('Laporan gagal diajukan!');
            document.location.href = 'index.php';
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendongadu</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Pengaduan</h1>

    <ul>
        <li>Nama Pelapor: <input type="text" name="nama" placeholder="Nama Pelapor"></li>
        <li>Kelas: <input type="text" name="kelas" placeholder="Kelas"></li>
        <li>Lokasi Kerusakan: <input type="text" name="lokasi" placeholder="Lokasi Kerusakan"></li>
        <li>Jenis Kerusakan: <input type="text" name="jenis" placeholder="Jenis Kerusakan"></li>
        <li>Deskripsi Kerusakan: <input type="text" name="deskripsi" placeholder="Deskripsi Kerusakan"></li>
        <li>Upload Foto: <input type="file" name="foto"></li>
        <li><button type="submit" name="submit">Ajukan Pengaduan</button></li><a href="login.php">login</a>
    </ul>
    
    </form>
</body>
</html>