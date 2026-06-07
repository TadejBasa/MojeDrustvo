<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/jwt.php';

header("Content-Type: application/json");

$headers = getallheaders();
$auth    = $headers["Authorization"] ?? "";

if (!str_starts_with($auth, "Bearer ")) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$token    = substr($auth, 7);
$uporabnik = preveriJWT($token);

if (!$uporabnik) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$id = (int)$uporabnik["id"];

$rezultat = mysqli_query($conn, "
    SELECT d.*, COUNT(p.id) AS stevilo_prijav
    FROM priljubljeni pr
    JOIN dogodek d ON d.id = pr.dogodek_id
    LEFT JOIN prijava p
        ON p.dogodek_id = d.id
        AND p.status != 'zavrnjena'
    WHERE pr.uporabnik_id = $id
    GROUP BY d.id
    ORDER BY d.datum_cas ASC
");

$dogodki = [];
while ($vrstica = mysqli_fetch_assoc($rezultat)) {
    $dogodki[] = $vrstica;
}

echo json_encode($dogodki);