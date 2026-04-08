<?php 
session_start();
$conn = mysqli_connect('localhost','root','','ukako');

if (isset($_POST['status']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $sql = "UPDATE laporan SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $sql);
    
    header("Location: laporan.php");
    exit;
}

function fetch($table) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM $table");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$laporan = fetch("laporan");

$isAdmin = isset($_SESSION["level"]) && $_SESSION["level"] === "admin";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Monitor</title>
    
</head>
<body>
    <h1>List Laporan</h1>
    <?php if($isAdmin) : ?>
    <a href="logout.php">logout</a>
    <?php endif; ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>Id</td>
            <td>Nama</td>
            <td>Kelas</td>
            <td>Lokasi</td>
            <td>Jenis</td>
            <td>Deskripsi</td>
            <td>Foto</td>
        <?php if($isAdmin) : ?>
            <td>Status</td>
            <td>Aksi</td>
        <?php else : ?>
            <td>Status</td>
        <?php endif; ?>
        </tr>
        <?php foreach($laporan as $l) : ?>
        <tr>
            <td><?php echo $l['id']; ?></td>
            <td><?php echo $l['nama']; ?></td>
            <td><?php echo $l['kelas']; ?></td>
            <td><?php echo $l['lokasi_kerusakan']; ?></td>
            <td><?php echo $l['jenis_kerusakan']; ?></td>
            <td><?php echo $l['deskripsi_kerusakan']; ?></td>
            <td><img src="<?php echo $l['foto']; ?>" alt="foto kerusakan" width="100"></td>
            <?php if($isAdmin) : ?>
            <td>
                <form action="" method="post" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $l['id']; ?>">
                    <select name="status" onchange="this.form.submit()">
                        <option value="menunggu" <?php if($l['status'] === 'menunggu') echo 'selected'; ?>>Menunggu</option>
                        <option value="proses" <?php if($l['status'] === 'proses') echo 'selected'; ?>>Proses</option>
                        <option value="selesai" <?php if($l['status'] === 'selesai') echo 'selected'; ?>>Selesai</option>
                    </select>
                </form>
            </td>
            <td><a href="hapus.php?id=<?php echo $l['id']; ?>" onclick="return confirm('Yakin?');" >Hapus</a></td>
            <?php else : ?>
            <td><?php echo $l['status']; ?></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>