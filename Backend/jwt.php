<?php
const JWT_SECRET = "TungTungSahur_kluc"; 

//pretvore podatke
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); //zamenja +,-,...
}

function base64url_decode($data) { //jwt v navadne podatke
    return base64_decode(strtr($data, '-_', '+/'));
}

//ustvari jwt token
function ustvariJWT($payload) {
    $header = ["alg" => "HS256", "typ" => "JWT"]; //da uporabljas jwt

    $base64Header = base64url_encode(json_encode($header));
    $base64Payload = base64url_encode(json_encode($payload));

    $signature = hash_hmac( //digitalni pdopis
        "sha256",
        $base64Header . "." . $base64Payload,
        JWT_SECRET,
        true
    );

    return $base64Header . "." . $base64Payload . "." . base64url_encode($signature); //koncne jwt
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

function getUser() {
    if (empty($_SESSION["jwt"])) return null;

    $u = preveriJWT($_SESSION["jwt"]);

    return $u;
}

?>