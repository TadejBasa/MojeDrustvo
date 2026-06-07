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
$novEmail = $_POST["novEmail"];

$stmt = $conn->prepare("UPDATE uporabnik SET ime = ?, priimek = ?, username = ?, email = ? WHERE id = ?");
$stmt->bind_param("ssssi", $novoIme, $novPriimek, $novoUporabnisko, $novEmail, $id);
$stmt->execute();

$novToken = ustvariJWT([
    "id" => $id,
    "username" => $novoUporabnisko,
    "exp" => time() + 3600  
]);
?>

<script>
    sessionStorage.setItem("jwt", <?= json_encode($novToken) ?>);
    window.location.href = "../Frontend/profil.php";
</script>
