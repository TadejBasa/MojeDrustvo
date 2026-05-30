
<?php

session_start();
require_once '../Backend/config.php';

if (!isset($_SESSION["uporabnik_id"])) {
    die("Nisi prijavljen");
}

$uporabnik["uporabnik_id"];
$dogodek_id = $_POST["dogodek_id"];
$besedilo = mysqli_real_escape_string($conn, $_POST["besedilo"]);

mysqli_query($conn, "
    INSERT INTO komentar (uporabnik_id, dogodek_id, besedilo)
    VALUES ($uporabnik_id, $dogodek_id, '$besedilo')
");

header("Location: ../Frontend/dogodki.php");
exit;

$besedilo = trim($_POST["besedilo"]);

if ($besedilo === "") {
    header("Location: ../Frontend/dogodki.php");
    exit;
}

?>