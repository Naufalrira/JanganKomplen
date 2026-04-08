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
    <title>Laporan Monitor — Pendongadu</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #1a1a2e;
        }
        .container { max-width: 1100px; margin: 0 auto; }
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
        .logo-name { font-size: 18px; font-weight: 700; }
        .logo-sub { font-size: 12px; color: #6b7280; }
        .btn-logout {
            font-size: 13px;
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            border: 1.5px solid #fecaca;
            padding: 6px 14px;
            border-radius: 7px;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: #fef2f2; }
        .page-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 1.25rem;
        }
        .table-wrap {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead tr { background: #f8f9ff; border-bottom: 2px solid #e5e7eb; }
        thead th {
            padding: 13px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }
        td { padding: 12px 16px; vertical-align: middle; color: #374151; }
        td img {
            width: 72px; height: 54px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-menunggu { background: #fef9c3; color: #854d0e; }
        .badge-proses   { background: #dbeafe; color: #1e40af; }
        .badge-selesai  { background: #dcfce7; color: #166534; }
        select {
            padding: 6px 10px;
            border: 1.5px solid #e5e7eb;
            border-radius: 7px;
            font-size: 13px;
            color: #374151;
            background: #fff;
            cursor: pointer;
            outline: none;
            transition: border-color 0.2s;
        }
        select:focus { border-color: #4f46e5; }
        .btn-hapus {
            font-size: 13px;
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            padding: 5px 12px;
            border: 1.5px solid #fecaca;
            border-radius: 7px;
            transition: background 0.15s;
            white-space: nowrap;
        }
        .btn-hapus:hover { background: #fef2f2; }
        .empty {
            text-align: center;
            padding: 3rem;
            color: #9ca3af;
            font-size: 15px;
        }
        @media (max-width: 768px) {
            table { font-size: 13px; }
            td, th { padding: 10px 10px; }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <div class="logo-icon">&#128204;</div>
            <div>
                <div class="logo-name">Pendongadu</div>
                <div class="logo-sub">Sistem Laporan Kerusakan</div>
            </div>
        </div>
        <?php if($isAdmin): ?>
        <a href="logout.php" class="btn-logout">Logout</a>
        <?php endif; ?>
    </header>

    <div class="page-title">Daftar Laporan</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Lokasi</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <?php if($isAdmin): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($laporan)): ?>
                <tr><td colspan="<?php echo $isAdmin ? 9 : 8; ?>" class="empty">Belum ada laporan yang masuk.</td></tr>
            <?php endif; ?>
            <?php foreach($laporan as $l): ?>
            <tr>
                <td style="color:#9ca3af;font-size:13px;"><?php echo $l['id']; ?></td>
                <td style="font-weight:600;"><?php echo htmlspecialchars($l['nama']); ?></td>
                <td><?php echo htmlspecialchars($l['kelas']); ?></td>
                <td><?php echo htmlspecialchars($l['lokasi_kerusakan']); ?></td>
                <td><?php echo htmlspecialchars($l['jenis_kerusakan']); ?></td>
                <td style="max-width:180px;color:#6b7280;"><?php echo htmlspecialchars($l['deskripsi_kerusakan']); ?></td>
                <td><img src="<?php echo htmlspecialchars($l['foto']); ?>" alt="foto kerusakan"></td>
                <?php if($isAdmin): ?>
                <td>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $l['id']; ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="menunggu" <?php if($l['status']==='menunggu') echo 'selected'; ?>>Menunggu</option>
                            <option value="proses"   <?php if($l['status']==='proses')   echo 'selected'; ?>>Proses</option>
                            <option value="selesai"  <?php if($l['status']==='selesai')  echo 'selected'; ?>>Selesai</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="hapus.php?id=<?php echo $l['id']; ?>" class="btn-hapus"
                       onclick="return confirm('Hapus laporan ini?');">Hapus</a>
                </td>
                <?php else: ?>
                <td>
                    <?php
                    $badge = 'badge-menunggu';
                    if($l['status']==='proses') $badge='badge-proses';
                    if($l['status']==='selesai') $badge='badge-selesai';
                    ?>
                    <span class="badge <?php echo $badge; ?>"><?php echo ucfirst($l['status']); ?></span>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>