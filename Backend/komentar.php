<?php

require_once 'config.php';
require_once 'jwt.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Neveljavna zahteva.");
}

$jwt = $_POST["jwt"] ?? "";
$dogodek_id = (int)($_POST["dogodek_id"] ?? 0);
$besedilo = trim($_POST["besedilo"] ?? "");

if (empty($jwt)) {
    die("Manjka JWT.");
}

$uporabnik = preveriJWT($jwt);
if (!$uporabnik) {
    die("Neveljaven JWT.");
}

$uporabnik_id = (int)$uporabnik["id"];

if ($besedilo === "") {
    die("Vnesi besedilo v komentar.");
}

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO komentar (dogodek_id, uporabnik_id, besedilo, datum)
     VALUES (?, ?, ?, NOW())"
);

mysqli_stmt_bind_param(
    $stmt,
    "iis",
    $dogodek_id,
    $uporabnik_id,
    $besedilo
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../Frontend/dogodki.php");
    exit;
} else {
    die("Napaka");
}