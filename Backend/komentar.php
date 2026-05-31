<?php
session_start();
require_once '../Backend/config.php';

if (!isset($_SESSION["uporabnik_id"])) {
    die("Uporabnik ni prijavljen v sistem.");
}

$uporabnik_id = (int)$_SESSION["uporabnik_id"];
$dogodek_id = (int)($_POST["dogodek_id"] ?? 0);
$besedilo = trim($_POST["besedilo"]);

if ($besedilo === "") {
    header("Location: ../Frontend/dogodki.php");
    exit;
}

$besedilo = mysqli_real_escape_string($conn, $besedilo);

mysqli_query($conn, "
    INSERT INTO komentar (uporabnik_id, dogodek_id, besedilo)
    VALUES ($uporabnik_id, $dogodek_id, '$besedilo')
");

header("Location: ../Frontend/dogodki.php");
exit;
?>