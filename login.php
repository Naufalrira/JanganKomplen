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
    <title>login</title>
</head>
<body>
    <form action="" method="post">
        <h1>Login bang</h1>
        <input type="text" name="username" placeholder="username">
        <input type="text" name="password" placeholder="password">
        <button type="submit">Login</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>