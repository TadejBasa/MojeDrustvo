<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["uporabnik_id"])) {
    header("Location: login.php");
    exit();
}

$id = (int)$_SESSION["uporabnik_id"];

$sql = "SELECT ime, priimek, username, email, datum_rojstva, vloga 
        FROM uporabnik 
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$uporabnik = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$uporabnik) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>