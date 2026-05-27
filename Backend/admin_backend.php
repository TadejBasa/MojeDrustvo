<?php
session_start();
require_once '../Frontend/config.php';

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: index.php");
    exit();
}

if (isset($_GET["brisi_dogodek"])) {
    $id_dogodka = (int)$_GET["brisi_dogodek"];
    mysqli_query($conn, "DELETE FROM prijava WHERE dogodek_id = $id_dogodka");
    mysqli_query($conn, "DELETE FROM dogodek WHERE id = $id_dogodka");
    header("Location: admin.php"); exit();
}

if (isset($_GET["brisi_objavo"])) {
    $id_objave = (int)$_GET["brisi_objavo"];
    mysqli_query($conn, "DELETE FROM objava WHERE id = $id_objave");
    header("Location: admin.php"); exit();
}

if (isset($_GET["potrdi"])) {
    $id_prijave = (int)$_GET["potrdi"];
    mysqli_query($conn, "UPDATE prijava SET status = 'potrjena' WHERE id = $id_prijave");
    header("Location: admin.php#prijave"); exit();
}

if (isset($_GET["zavrni"])) {
    $id_prijave = (int)$_GET["zavrni"];
    mysqli_query($conn, "UPDATE prijava SET status = 'zavrnjena' WHERE id = $id_prijave");
    header("Location: admin.php#prijave"); exit();
}

if (isset($_POST["dodaj_dogodek"])) {
    $naslov    = trim($_POST["naslov"]);
    $opis      = trim($_POST["opis"]);
    $lokacija  = trim($_POST["lokacija"]);
    $datum     = $_POST["datum_cas"];
    $cena      = (float)$_POST["cena"];
    $st_mest   = (int)$_POST["st_mest"];
    $vrsta     = $_POST["vrsta"];
    $slika_url = trim($_POST["slika_url"]);
    $je_javen  = isset($_POST["je_javen"]) ? 1 : 0;
    $kreator   = $_SESSION["uporabnik_id"];

    if (!empty($_FILES["slika_datoteka"]["name"])) {
    $ime_datoteke = time() . "_" . basename($_FILES["slika_datoteka"]["name"]);
    $cilj = __DIR__ . "/../Frontend/uploads/" . $ime_datoteke;;
    
    if (move_uploaded_file($_FILES["slika_datoteka"]["tmp_name"], $cilj)) {
        $slika_url = "../Frontend/uploads/" . $ime_datoteke;
    }
}


    $stmt = mysqli_prepare($conn, "INSERT INTO dogodek (naslov, opis, lokacija, datum_cas, cena, st_mest, vrsta, slika_url, je_javen, kreator_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssdissii", $naslov, $opis, $lokacija, $datum, $cena, $st_mest, $vrsta, $slika_url, $je_javen, $kreator);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_error($stmt)) {
        die(mysqli_stmt_error($stmt));
}
header("Location: admin.php#dogodki"); exit();
}

if (isset($_POST["dodaj_objavo"])) {
    $naslov      = trim($_POST["naslov_o"]);
    $vsebina     = trim($_POST["vsebina"]);
    $tip         = $_POST["tip"];
    $je_javna    = isset($_POST["je_javna"]) ? 1 : 0;
    $je_pomembna = isset($_POST["je_pomembna"]) ? 1 : 0;
    $avtor       = $_SESSION["uporabnik_id"];

    $stmt = mysqli_prepare($conn, "INSERT INTO objava (naslov, vsebina, tip, je_javna, je_pomembna, avtor_id) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssiii", $naslov, $vsebina, $tip, $je_javna, $je_pomembna, $avtor);
    mysqli_stmt_execute($stmt);
    header("Location: admin.php#objave"); exit();
}


$vsi_dogodki = mysqli_query($conn, "SELECT * FROM dogodek ORDER BY datum_cas DESC");
$vse_objave  = mysqli_query($conn, "SELECT * FROM objava ORDER BY datum_objave DESC");
$vsi_clani   = mysqli_query($conn, "SELECT * FROM uporabnik ORDER BY datum_reg DESC");

$prijave_cakanje = mysqli_query($conn, "SELECT p.*, u.ime, u.priimek, d.naslov as naziv_dogodka
                                         FROM prijava p
                                         JOIN uporabnik u ON p.uporabnik_id = u.id
                                         JOIN dogodek d ON p.dogodek_id = d.id
                                         WHERE p.status = 'cakanje'
                                         ORDER BY p.datum_prijave DESC");