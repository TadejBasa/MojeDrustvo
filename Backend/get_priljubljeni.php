<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

$uporabnik = null;
if (!empty($_POST["jwt"])) {
    $uporabnik = preveriJWT($_POST["jwt"]);
}

if (!$uporabnik) {
    echo json_encode([]);
    exit;
}

$id = (int)$uporabnik["id"];
$rezultat = mysqli_query($conn, "SELECT dogodek_id FROM priljubljeni WHERE uporabnik_id = $id");

$ids = [];
while ($vrstica = mysqli_fetch_assoc($rezultat)) {
    $ids[] = (int)$vrstica["dogodek_id"];
}

echo json_encode($ids);