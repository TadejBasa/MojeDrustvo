<?php
const JWT_SECRET = "TungTungSahur_kluc";

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function ustvariJWT($payload) {
    $header = ["alg" => "HS256", "typ" => "JWT"];

    $base64Header = base64url_encode(json_encode($header));
    $base64Payload = base64url_encode(json_encode($payload));

    $signature = hash_hmac(
        "sha256",
        $base64Header . "." . $base64Payload,
        JWT_SECRET,
        true
    );

    return $base64Header . "." . $base64Payload . "." . base64url_encode($signature);
}

function preveriJWT($jwt) {
    $deli = explode(".", $jwt);
    if (count($deli) !== 3) return false;

    [$header, $payload, $signature] = $deli;

    $preveri = base64url_encode(hash_hmac(
        "sha256",
        $header . "." . $payload,
        JWT_SECRET,
        true
    ));

    if (!hash_equals($preveri, $signature)) return false;

    $data = json_decode(base64url_decode($payload), true);

    if (!$data || ($data["exp"] ?? 0) < time()) return false;

    return $data;
}
?>