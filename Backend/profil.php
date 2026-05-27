<?php
require_once "config.php";
require_once "jwt.php";

header("Content-Type: application/json");

$headers = getallheaders();

$auth = $headers["Authorization"] ?? "";

if (!str_starts_with($auth, "Bearer ")) {
    http_response_code(401);
    echo json_encode(["napaka" => "Manjka token"]);
    exit;
}

$token = substr($auth, 7);

$data = preveriJWT($token);

if (!$data) {
    http_response_code(401);
    echo json_encode(["napaka" => "Neveljaven token"]);
    exit;
}

$id = $data["id"];

$sql = "SELECT ime, priimek, username, datum_rojstva
        FROM uporabnik
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$uporabnik = mysqli_fetch_assoc($result);

echo json_encode($uporabnik);