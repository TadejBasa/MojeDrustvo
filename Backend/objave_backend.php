<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

$uporabnik = null;
if (!empty($_COOKIE["jwt"])) {
    $uporabnik = preveriJWT($_COOKIE["jwt"]);
}

$izbrani_tip = $_GET["tip"] ?? "vse";

$pogoj = $uporabnik ? "WHERE 1=1" : "WHERE je_javna = 1";

if ($izbrani_tip != "vse") {
    $tip_varen = mysqli_real_escape_string($conn, $izbrani_tip);
    $pogoj .= " AND tip = '$tip_varen'";
}

$objave = mysqli_query($conn, "SELECT * FROM objava $pogoj ORDER BY datum_objave DESC");

$tipi = [
    "vse"       => "Vse",
    "novica"    => "Novice",
    "obvestilo" => "Obvestila",
    "vabilo"    => "Vabila"
];