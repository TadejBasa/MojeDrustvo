<?php
session_start();
require_once 'config.php';

if (isset($_SESSION["uporabnik_id"])) {
    header("Location: index.php");
    exit();
}

$napaka = "";
$uspeh = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = trim($_POST["ime"]);
    $priimek = trim($_POST["priimek"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $geslo = $_POST["geslo"];
    $datum_rojstva = $_POST["datum_rojstva"];

    $geslo_hash = password_hash($geslo, PASSWORD_DEFAULT);
    $vloga = "clan";

    $sql = "INSERT INTO uporabnik
    (ime, priimek, username, email, geslo_hash, vloga, datum_rojstva)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $ime,
        $priimek,
        $username,
        $email,
        $geslo_hash,
        $vloga,
        $datum_rojstva
    );

    if(mysqli_stmt_execute($stmt)){
      $uspeh = "Registracija uspešna";
    }else{
      $napaka = "Napaka pri registraciji";
    }

    $uspeh = "Registracija uspešna";
}
?>