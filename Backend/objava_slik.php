<?php
require_once "config.php";
require_once "jwt.php";

$token = $_POST["jwt"] ?? "";

if (!$token) {
    exit("Ni tokena");
}

$data = preveriJWT($token);

if (!$data) {
    exit("Neveljaven token");
}

$id = $data["id"];

$target_dir = "../Frontend/profilne_slike/";
$target_file = $target_dir . "profilna_" . $id . ".png";

if (!isset($_FILES["profilnaSlika"])) {
    exit("Slika ni bila poslana.");
}

if (move_uploaded_file($_FILES["profilnaSlika"]["tmp_name"], $target_file)) {

    $pot = "profilne_slike/profilna_" . $id . ".png";

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE uporabnik SET profilna_slika = ? WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "si", $pot, $id);
    mysqli_stmt_execute($stmt);

    header("Location: ../Frontend/profil.php");
    exit;
}

exit("Napaka pri nalaganju slike.");
?>