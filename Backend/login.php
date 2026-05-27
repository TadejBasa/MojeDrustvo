<?php
require_once "config.php";
require_once "jwt.php";

$vhod = $_POST["vhod"] ?? "";
$geslo = $_POST["geslo"] ?? "";

$sql = "SELECT * FROM uporabnik WHERE username = ? OR email = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ss", $vhod, $vhod);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$uporabnik = mysqli_fetch_assoc($result);

if (!$uporabnik || !password_verify($geslo, $uporabnik["geslo_hash"])) {
    header("Location: ../Frontend/login.php?napaka=Napacno uporabnisko ime ali geslo");
    exit;
}

$token = ustvariJWT([
    "id" => $uporabnik["id"],
    "username" => $uporabnik["username"],
    "vloga" => $uporabnik["vloga"],
    "exp" => time() + 3600
]);
?>

<script>
sessionStorage.setItem("jwt", <?= json_encode($token) ?>);
window.location.href = "../Frontend/profil.php";
</script>