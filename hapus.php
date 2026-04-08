<?php
$conn = mysqli_connect('localhost','root','','ukako');

$id=$_GET["id"];
mysqli_query($conn, "DELETE FROM laporan WHERE id = $id");

header("Location: laporan.php");

?>