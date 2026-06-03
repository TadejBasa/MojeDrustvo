<?php
session_start();
require_once "config.php";
require_once "jwt.php";

//podatke iz forme
$vhod = $_POST["vhod"] ?? ""; 
$geslo = $_POST["geslo"] ?? "";

$sql = "SELECT * FROM uporabnik WHERE username = ? OR email = ?"; //po username ale email

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ss", $vhod, $vhod);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$uporabnik = mysqli_fetch_assoc($result); //podatki iz baze

if (!$uporabnik || !password_verify($geslo, $uporabnik["geslo_hash"])) { //se geslo ujema
    header("Location: ../Frontend/login.php?napaka=Napacno uporabnisko ime ali geslo");
    exit;
}

//jwt token 
$token = ustvariJWT([
    "id" => $uporabnik["id"],
    "username" => $uporabnik["username"],
    "vloga" => $uporabnik["vloga"],
    "exp" => time() + 3600 //cas kda potece
]);
?>

<script>
sessionStorage.setItem("jwt", <?= json_encode($token) ?>);
window.location.replace("../Frontend/profil.php");
</script>