<?php
require_once 'config.php';

$uporabniki = [
    ["Admin",   "Društvo",  "admin",   "admin@mojedrustvo.si",  "admin123",  "admin"],
    ["Janez",   "Novak",    "janez",   "janez@test.si",         "geslo123",  "clan"],
    ["Ana",     "Kovač",    "ana",     "ana@test.si",           "geslo123",  "clan"],
    ["Maja",    "Horvat",   "maja",    "maja@test.si",          "geslo123",  "clan"],
    ["Luka",    "Krajnc",   "luka",    "luka@test.si",          "geslo123",  "clan"],
    ["Nina",    "Zupan",    "nina",    "nina@test.si",          "geslo123",  "clan"],
    ["Tilen",   "Potočnik", "tilen",   "tilen@test.si",         "geslo123",  "clan"],
    ["Sara",    "Berger",   "sara",    "sara@test.si",          "geslo123",  "clan"],
    ["Matic",   "Oblak",    "matic",   "matic@test.si",         "geslo123",  "clan"],
    ["Eva",     "Černač",   "eva",     "eva@test.si",           "geslo123",  "clan"],
];

$uspesno = 0;
$napake  = 0;

foreach ($uporabniki as $u) {
    $hash = password_hash($u[4], PASSWORD_DEFAULT);
    $sql  = "INSERT INTO uporabnik (ime, priimek, username, email, geslo_hash, vloga)
             VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $u[0], $u[1], $u[2], $u[3], $hash, $u[5]);

    if (mysqli_stmt_execute($stmt)) {
        $uspesno++;
        echo "Dodan: " . $u[2] . " (" . $u[5] . ")<br>";
    } else {
        $napake++;
        echo "Napaka pri: " . $u[2] . " — " . mysqli_error($conn) . "<br>";
    }
}

echo "<hr>";
echo "Skupaj dodanih: <b>$uspesno</b><br>";
if ($napake > 0) {
    echo "Napake: <b>$napake</b><br>";
}
?>