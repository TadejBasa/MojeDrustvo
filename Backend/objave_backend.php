<?php
session_start();
require_once '../Frontend/config.php';

$izbrani_tip = $_GET["tip"] ?? "vse";

$pogoj = isset($_SESSION["uporabnik_id"]) ? "WHERE 1=1" : "WHERE je_javna = 1";

if ($izbrani_tip != "vse") {
    $tip_varen = mysqli_real_escape_string($conn, $izbrani_tip);
    $pogoj .= " AND tip = '$tip_varen'";
}

$objave = mysqli_query($conn, "SELECT * FROM objava $pogoj ORDER BY datum_objave DESC");

$tipi = [
    "vse"       => "Vse",
    "novica"    => "Novice",
    "obvestilo" => "Obvestila",
    "zapisnik"  => "Zapisniki",
    "vabilo"    => "Vabila"
];