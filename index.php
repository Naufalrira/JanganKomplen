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
    <title>Pendongadu — Pengaduan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-icon {
            width: 38px; height: 38px;
            background: #4f46e5;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 18px;
        }
        .logo-name { font-size: 18px; font-weight: 700; color: #1a1a2e; }
        header a {
            font-size: 13px;
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            border: 1.5px solid #c7d2fe;
            padding: 6px 14px;
            border-radius: 7px;
            transition: background 0.15s;
        }
        header a:hover { background: #eef2ff; }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }
        .card h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.25rem;
        }
        .card p.sub {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field.full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: 600; color: #374151; }
        input[type=text], textarea {
            padding: 10px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a2e;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }
        input[type=text]:focus, textarea:focus { border-color: #4f46e5; }
        textarea { resize: vertical; min-height: 80px; }
        .file-upload {
            border: 2px dashed #c7d2fe;
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .file-upload:hover { border-color: #4f46e5; background: #eef2ff; }
        .file-upload span { font-size: 13px; color: #6b7280; display: block; margin-top: 4px; }
        .file-upload input[type=file] { display: none; }
        .file-label {
            font-size: 14px; font-weight: 600; color: #4f46e5; cursor: pointer;
        }
        .divider { height: 1px; background: #f3f4f6; margin: 1.25rem 0; }
        .actions { display: flex; align-items: center; gap: 12px; }
        button[type=submit] {
            padding: 11px 28px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type=submit]:hover { background: #4338ca; }
        @media (max-width: 480px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <div class="logo-icon">&#128204;</div>
            <div class="logo-name">Pendongadu</div>
        </div>
        <a href="login.php">Login Admin</a>
    </header>

    <div class="card">
        <h1>Form Pengaduan</h1>
        <p class="sub">Laporkan kerusakan fasilitas di sekolah</p>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="field">
                    <label for="nama">Nama Pelapor</label>
                    <input type="text" id="nama" name="nama" placeholder="Nama lengkap">
                </div>
                <div class="field">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" placeholder="Contoh: XII IPA 1">
                </div>
                <div class="field">
                    <label for="lokasi">Lokasi Kerusakan</label>
                    <input type="text" id="lokasi" name="lokasi" placeholder="Contoh: Lab Komputer">
                </div>
                <div class="field">
                    <label for="jenis">Jenis Kerusakan</label>
                    <input type="text" id="jenis" name="jenis" placeholder="Contoh: AC rusak">
                </div>
                <div class="field full">
                    <label for="deskripsi">Deskripsi Kerusakan</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan kerusakan secara detail..."></textarea>
                </div>
                <div class="field full">
                    <label>Foto Kerusakan</label>
                    <label class="file-upload" for="foto">
                        <div style="font-size:24px;">&#128247;</div>
                        <div class="file-label">Klik untuk pilih foto</div>
                        <span>JPG, PNG, WEBP — maks. 7 MB</span>
                        <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp">
                    </label>
                    <span id="file-name" style="font-size:13px;color:#6b7280;margin-top:4px;"></span>
                </div>
            </div>
            <div class="divider"></div>
            <div class="actions">
                <button type="submit" name="submit">Ajukan Pengaduan</button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('foto').addEventListener('change', function(){
    const name = this.files[0] ? this.files[0].name : '';
    document.getElementById('file-name').textContent = name ? '&#128206; ' + name : '';
});
</script>
</body>
</html>