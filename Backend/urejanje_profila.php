<?php
require "config.php";
require "jwt.php";

$token = $_POST["jwt"] ?? "";

if (!$token) {
    exit("Ni tokena");
}

$data = preveriJWT($token);

if (!$data) {
    exit("Neveljaven token");
}

$id = $data["id"];

$novoIme = $_POST["novoIme"];
$novPriimek = $_POST["novPriimek"];
$novoUporabnisko = $_POST["novoUporabnisko"];

$stmt = $conn->prepare("UPDATE uporabnik SET ime = ?, priimek = ?, username = ? WHERE id = ?");
$stmt->bind_param("sssi", $novoIme, $novPriimek, $novoUporabnisko, $id);
$stmt->execute();

header("Location: ../Frontend/profil.php");
exit;