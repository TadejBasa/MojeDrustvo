<?php
session_start();
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

$uporabnik = null;
if (!empty($_SESSION["jwt"])) {
    $uporabnik = preveriJWT($_SESSION["jwt"]);
}

if (!$uporabnik || $uporabnik["vloga"] != "admin") {
    header("Location: ../Frontend/index.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = mysqli_prepare($conn, "SELECT * FROM dogodek WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$d) {
    header("Location: ../Frontend/admin.php");
    exit();
}

$napaka = "";
$uspeh  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov   = trim($_POST["naslov"]);
    $opis     = trim($_POST["opis"]);
    $lokacija = trim($_POST["lokacija"]);
    $datum    = $_POST["datum_cas"];
    $cena     = (float)$_POST["cena"];
    $mesta    = (int)$_POST["st_mest"];
    $vrsta    = $_POST["vrsta"];
    $javen    = isset($_POST["je_javen"]) ? 1 : 0;

    if (empty($naslov) || empty($datum)) {
        $napaka = "Naslov in datum sta obvezna.";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE dogodek SET naslov=?, opis=?, lokacija=?, datum_cas=?, cena=?, st_mest=?, vrsta=?, je_javen=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssdisii", $naslov, $opis, $lokacija, $datum, $cena, $mesta, $vrsta, $javen, $id);

        if (mysqli_stmt_execute($stmt)) {
            $uspeh = "Dogodek uspešno posodobljen!";
            $d["naslov"]    = $naslov;
            $d["opis"]      = $opis;
            $d["lokacija"]  = $lokacija;
            $d["datum_cas"] = $datum;
            $d["cena"]      = $cena;
            $d["st_mest"]   = $mesta;
            $d["vrsta"]     = $vrsta;
            $d["je_javen"]  = $javen;
        } else {
            $napaka = "Napaka pri shranjevanju.";
        }
    }
}