
<?php

session_start();
require_once '../Backend/config.php';
require_once '../Backend/jwt.php';

$uporabnik = getUser();

if (!$uporabnik) {
    die("Uporabnik ni prijavljen");
}

$user_id = (int)$uporabnik["id"];
$dogodek_id = (int)($_POST["dogodek_id"] ?? 0);

$check = mysqli_query($conn, "SELECT id FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");

if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "DELETE FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");
} else {
    mysqli_query($conn, "INSERT INTO priljubljeni (uporabnik_id, dogodek_id) VALUES ($user_id, $dogodek_id)");
}

header("Location: ../Frontend/dogodki.php");
exit;

?>