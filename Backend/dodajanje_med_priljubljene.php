
<?php

session_start();
require_once '../Backend/config.php';

if (!isset($_SESSION["uporabnik_id"])) {
    die("Nisi prijavljen");
}

$uporabnik["uporabnik_id"];
$dogodek_id = $_POST["dogodek_id"];

$check = mysqli_query($conn, "SELECT id FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");

if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "DELETE FROM priljubljeni WHERE uporabnik_id=$user_id AND dogodek_id=$dogodek_id");
} else {
    mysqli_query($conn, "INSERT INTO priljubljeni (uporabnik_id, dogodek_id) VALUES ($user_id, $dogodek_id)");
}

header("Location: ../Frontend/dogodki.php");
exit;

?>