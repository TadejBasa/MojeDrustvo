<?php
session_start();
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

$uporabnik = null;
if (!empty($_SESSION["jwt"])) {
    $uporabnik = preveriJWT($_SESSION["jwt"]);
}

$izbrana_vrsta = $_GET["vrsta"] ?? "vse";
$sporocilo = "";

if (isset($_POST["prijava_dogodek"]) && $uporabnik) {
    $id_dogodka    = (int)$_POST["dogodek_id"];
    $id_uporabnika = (int)$uporabnik["id"];

    $obstojna = mysqli_query($conn, "SELECT id FROM prijava WHERE uporabnik_id = $id_uporabnika AND dogodek_id = $id_dogodka");

    if (mysqli_num_rows($obstojna) > 0) {
        $sporocilo = "Ze si prijavljen na ta dogodek.";
    } else {
        mysqli_query($conn, "INSERT INTO prijava (uporabnik_id, dogodek_id, status) VALUES ($id_uporabnika, $id_dogodka, 'cakanje')");
        $sporocilo = "Prijava uspesna! Caka na potrditev admina.";
    }
}

$pogoj = $uporabnik ? "WHERE 1=1" : "WHERE je_javen = 1";

if ($izbrana_vrsta != "vse") {
    $vrsta_varna = mysqli_real_escape_string($conn, $izbrana_vrsta);
    $pogoj .= " AND vrsta = '$vrsta_varna'";
}

$dogodki = mysqli_query($conn, "SELECT * FROM dogodek $pogoj ORDER BY datum_cas ASC");

$vrste = [
    "vse"       => "Vsi",
    "pohod"     => "Pohodi",
    "delavnica" => "Delavnice",
    "izlet"     => "Izleti",
    "turnir"    => "Turnirji",
    "drugo"     => "Drugo"
];