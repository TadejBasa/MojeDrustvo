<?php
require_once "config.php";
require_once "jwt.php";
require_once "mail.php";

$ime = $_POST["ime"] ?? "";
$priimek = $_POST["priimek"] ?? "";
$username = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$datum = $_POST["datum_rojstva"] ?? "";

$gesloHash = password_hash($_POST["geslo"], PASSWORD_DEFAULT); //shrane geslo kak hash

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM uporabnik WHERE username = ? OR email = ?"
);

mysqli_stmt_bind_param($check, "ss", $username, $email);

mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);

if(mysqli_fetch_assoc($result)) {
    header("Location: ../Frontend/register.php?napaka=Uporabnik ali email ze obstaja");
    exit;
}

$sql = "INSERT INTO uporabnik
(ime, priimek, username, email, geslo_hash, datum_rojstva)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $ime,
    $priimek,
    $username,
    $email,
    $gesloHash,
    $datum
);

mysqli_stmt_execute($stmt);

posljiRegistracijskiMail($email, $ime);

$id = mysqli_insert_id($conn);

//avtomatsko prijavi
$token = ustvariJWT([
    "id" => $id,
    "username" => $username,
    "exp" => time() + 3600
]);
?>

<script>
sessionStorage.setItem("jwt", <?= json_encode($token) ?>); //vpis v session storage
window.location.href = "../Frontend/profil.php";
</script>