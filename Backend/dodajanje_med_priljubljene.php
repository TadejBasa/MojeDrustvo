<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/jwt.php';

header('Content-Type: application/json');

$uporabnik = null;
if (!empty($_POST["jwt"])) {
    $uporabnik = preveriJWT($_POST["jwt"]);
}

if (!$uporabnik) {
    echo json_encode(['status' => 'napaka', 'sporocilo' => 'Ni avtorizacije']);
    exit;
}

$user_id    = (int)$uporabnik["id"];
$dogodek_id = (int)($_POST["dogodek_id"] ?? 0);

if ($dogodek_id > 0) {
    $check = mysqli_query($conn, "SELECT id FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");
        echo json_encode(['status' => 'odstranjeno']);
    } else {
        mysqli_query($conn, "INSERT INTO priljubljeni (uporabnik_id, dogodek_id) VALUES ($user_id, $dogodek_id)");
        echo json_encode(['status' => 'dodano']);
    }
} else {
    echo json_encode(['status' => 'napaka', 'sporocilo' => 'Neveljaven dogodek']);
}
exit;