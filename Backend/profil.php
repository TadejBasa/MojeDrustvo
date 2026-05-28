<?php
require_once "config.php";
require_once "jwt.php";

header("Content-Type: application/json");

$headers = getallheaders(); //vsi headerji

$auth = $headers["Authorization"] ?? ""; //dobi auth.

if (!str_starts_with($auth, "Bearer ")) { //ali token obstaja
    http_response_code(401);
    echo json_encode(["napaka" => "Manjka token"]);
    exit;
}

$token = substr($auth, 7); //samo jwt brez bearer

$data = preveriJWT($token); //je veljaven

if (!$data) {
    http_response_code(401);
    echo json_encode(["napaka" => "Neveljaven token"]);
    exit;
}

$id = $data["id"]; //dobi id

//podatke uporabnika
$sql = "SELECT ime, priimek, username, datum_rojstva
        FROM uporabnik
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$uporabnik = mysqli_fetch_assoc($result);

echo json_encode($uporabnik);