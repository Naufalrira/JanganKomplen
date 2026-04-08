<?php 
session_start();
$conn = mysqli_connect('localhost','root','','ukako');

$message = '';
if(isset($_POST['username'])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' OR id = '$username'");


    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if ($password === $row["password"]) {
            $_SESSION["login"] = true;
            $_SESSION["level"] = "admin";
            header("Location: laporan.php");
            exit;
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Pendongadu</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.75rem;
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: #4f46e5;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 20px;
        }
        .logo-text { font-size: 20px; font-weight: 700; color: #1a1a2e; }
        .logo-sub { font-size: 13px; color: #6b7280; }
        h1 { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 0.25rem; }
        p.sub { font-size: 14px; color: #6b7280; margin-bottom: 1.5rem; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .field { margin-bottom: 1rem; }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a2e;
            transition: border-color 0.2s;
            outline: none;
        }
        input[type=text]:focus, input[type=password]:focus { border-color: #4f46e5; }
        button[type=submit] {
            width: 100%;
            padding: 11px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }
        button[type=submit]:hover { background: #4338ca; }
        .error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon">&#128204;</div>
            <div>
                <div class="logo-text">Pendongadu</div>
                <div class="logo-sub">Sistem Laporan Kerusakan</div>
            </div>
        </div>
        <h1>Selamat datang</h1>
        <p class="sub">Masuk untuk mengelola laporan</p>
        <form action="" method="post">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password">
            </div>
            <button type="submit">Masuk</button>
        </form>
        <?php if($message): ?>
        <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>