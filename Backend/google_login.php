<?php
require_once "config.php";
require_once "jwt.php";
require_once "mail.php";
require_once "../vendor/autoload.php";

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$googleToken = $input["credential"] ?? "";

if (!$googleToken) {
    echo json_encode(["napaka" => "Manjka Google token"]);
    exit;
}

$client = new Google_Client([
    "client_id" => "624964479245-cnjesbkvicibe8mf18n5iicd1hh7qg7u.apps.googleusercontent.com"
]);

$payload = $client->verifyIdToken($googleToken);

if (!$payload) {
    echo json_encode(["napaka" => "Neveljaven Google token"]);
    exit;
}

$email = $payload["email"];
$ime = $payload["given_name"] ?? "";
$priimek = $payload["family_name"] ?? "";
$username = explode("@", $email)[0];

$stmt = mysqli_prepare($conn, "SELECT * FROM uporabnik WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$uporabnik = mysqli_fetch_assoc($result);

if (!$uporabnik) {
    $gesloHash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
    $conn,
    "INSERT INTO uporabnik
    (ime, priimek, username, email, geslo_hash, vrsta_prijave)
    VALUES (?, ?, ?, ?, ?, 'google')"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $ime,
        $priimek,
        $username,
        $email,
        $gesloHash
    );

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
    echo json_encode(["napaka" => mysqli_stmt_error($stmt)]);
    exit;
    }

    posljiRegistracijskiMail($email, $ime);

    $id = mysqli_insert_id($conn);

    $uporabnik = [
        "id" => $id,
        "username" => $username,
        "vloga" => "clan"
    ];
}

$token = ustvariJWT([
    "id" => $uporabnik["id"],
    "username" => $uporabnik["username"],
    "vloga" => $uporabnik["vloga"] ?? "clan",
    "exp" => time() + 3600
]);

echo json_encode([
    "token" => $token
]);
?>