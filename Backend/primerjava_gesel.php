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

$trenutnoGeslo = $_POST["trenutnoGeslo"];
$novoGeslo = $_POST["novoGeslo"];
$potrdiGeslo = $_POST["potrdiGeslo"];

$stmt = $conn->prepare("SELECT geslo_hash FROM uporabnik WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$rezultat = $stmt->get_result();
$uporabnik = $rezultat->fetch_assoc();


if (!password_verify($trenutnoGeslo, $uporabnik["geslo_hash"])) {
    header("Location: ../Frontend/profil.php?geslo=1&napaka=" . urlencode("Napačno trenutno geslo"));
    exit;
}

if ($novoGeslo !== $potrdiGeslo) {
    header("Location: ../Frontend/profil.php?napaka=" . urlencode("Gesli se ne ujemata"));
    exit;
}

$novHash = password_hash($novoGeslo, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE uporabnik SET geslo_hash = ? WHERE id = ?");
$stmt->bind_param("si", $novHash, $id);
$stmt->execute();

header("Location: ../Frontend/profil.php");
exit;