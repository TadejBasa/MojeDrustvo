<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

$jwtToken  = $_POST["jwt"] ?? $_GET["jwt"] ?? "";
$uporabnik = $jwtToken ? preveriJWT($jwtToken) : null;

if (!$uporabnik || $uporabnik["vloga"] != "admin") {
    header("Location: ../Frontend/index.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = mysqli_prepare($conn, "SELECT * FROM objava WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$o = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$o) {
    header("Location: ../Frontend/admin.php?jwt=" . urlencode($jwtToken));
    exit();
}

$napaka = "";
$uspeh  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov      = trim($_POST["naslov"]);
    $vsebina     = trim($_POST["vsebina"]);
    $tip         = $_POST["tip"];
    $je_javna    = isset($_POST["je_javna"]) ? 1 : 0;
    $je_pomembna = isset($_POST["je_pomembna"]) ? 1 : 0;

    if (empty($naslov)) {
        $napaka = "Naslov je obvezen.";
    } else {
        $stmt2 = mysqli_prepare($conn, "UPDATE objava SET naslov=?, vsebina=?, tip=?, je_javna=?, je_pomembna=? WHERE id=?");
        mysqli_stmt_bind_param($stmt2, "sssiii", $naslov, $vsebina, $tip, $je_javna, $je_pomembna, $id);

        if (mysqli_stmt_execute($stmt2)) {
            $uspeh = "Objava uspešno posodobljena!";
            $o["naslov"]      = $naslov;
            $o["vsebina"]     = $vsebina;
            $o["tip"]         = $tip;
            $o["je_javna"]    = $je_javna;
            $o["je_pomembna"] = $je_pomembna;
        } else {
            $napaka = "Napaka pri shranjevanju.";
        }
    }
}