<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "mojedrustvo";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>