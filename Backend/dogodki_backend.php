<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

$uporabnik = null;
if (!empty($_SESSION["jwt"])) {
    $uporabnik = preveriJWT($_SESSION["jwt"]);
}
if (!$uporabnik && !empty($_POST["jwt"])) {
    $uporabnik = preveriJWT($_POST["jwt"]);
}
$izbrana_vrsta = $_GET["vrsta"] ?? "vse";
$sporocilo = "";

if (isset($_POST["prijava_dogodek"]) && $uporabnik) {

    $dogodek_id    = (int)$_POST["dogodek_id"];
    $id_uporabnika = (int)$uporabnik["id"];

    $sql = "
        SELECT d.st_mest, COUNT(p.id) AS prijave
        FROM dogodek d
        LEFT JOIN prijava p
            ON p.dogodek_id = d.id
            AND p.status != 'zavrnjena'
        WHERE d.id = $dogodek_id
        GROUP BY d.id
    ";

    $rezultat = mysqli_query($conn, $sql);

    if (!$rezultat || mysqli_num_rows($rezultat) == 0) {
        $sporocilo = "Dogodek ne obstaja.";
    } else {
        $vrstica = mysqli_fetch_assoc($rezultat);
        $prosta_mesta = (int)$vrstica["st_mest"] - (int)$vrstica["prijave"];

        if ($prosta_mesta <= 0) {
            $sporocilo = "Dogodek je zaseden.";
        } else {
            $obstojna = mysqli_query($conn,
                "SELECT id FROM prijava
                 WHERE uporabnik_id = $id_uporabnika
                 AND dogodek_id = $dogodek_id
                 AND status != 'zavrnjena'"
            );

            if (mysqli_num_rows($obstojna) > 0) {
                $sporocilo = "Že si prijavljen na ta dogodek.";
            } else {
                mysqli_query($conn,
                    "INSERT INTO prijava (uporabnik_id, dogodek_id, status)
                     VALUES ($id_uporabnika, $dogodek_id, 'cakanje')"
                );
                $sporocilo = "Prijava uspešna! Čaka na potrditev admina.";
            }
        }
    }
}

$pogoj = $uporabnik ? "WHERE 1=1" : "WHERE d.je_javen = 1";

if ($izbrana_vrsta != "vse") {
    $vrsta_varna = mysqli_real_escape_string($conn, $izbrana_vrsta);
    $pogoj .= " AND d.vrsta = '$vrsta_varna'";
}

$dogodki = mysqli_query($conn, "
    SELECT d.*, COUNT(p.id) AS stevilo_prijav
    FROM dogodek d
    LEFT JOIN prijava p
        ON p.dogodek_id = d.id
        AND p.status != 'zavrnjena'
    $pogoj
    GROUP BY d.id
    ORDER BY d.datum_cas ASC
");

$vrste = [
    "vse"       => "Vsi",
    "pohod"     => "Pohodi",
    "delavnica" => "Delavnice",
    "izlet"     => "Izleti",
    "turnir"    => "Turnirji",
    "drugo"     => "Drugo",
];

$jwtToken = $_COOKIE["jwt"] ?? $_SESSION["jwt"] ?? null;