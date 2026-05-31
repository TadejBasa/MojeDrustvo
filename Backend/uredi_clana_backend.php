<?php
require_once __DIR__ . "/jwt.php";
require_once __DIR__ . "/config.php";

$jwtToken  = $_POST["jwt"] ?? $_GET["jwt"] ?? "";
$uporabnik = $jwtToken ? preveriJWT($jwtToken) : null;

if (!$uporabnik || $uporabnik["vloga"] != "admin") {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET["id"];

$stmt = mysqli_prepare($conn, "SELECT * FROM uporabnik WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$u = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$u) {
    header("Location: admin.php?jwt=" . urlencode($jwtToken));
    exit();
}

$napaka = "";
$uspeh  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime           = trim($_POST["ime"]);
    $priimek       = trim($_POST["priimek"]);
    $username      = trim($_POST["username"]);
    $email         = trim($_POST["email"]);
    $vloga         = $_POST["vloga"];
    $datum_rojstva = !empty($_POST["datum_rojstva"]) ? $_POST["datum_rojstva"] : null;
    $aktiven       = isset($_POST["aktiven"]) ? 1 : 0;

    if (empty($ime) || empty($priimek) || empty($username) || empty($email)) {
        $napaka = "Ime, priimek, username in e-pošta so obvezni.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $napaka = "E-poštni naslov ni veljaven.";
    } else {
        $stmtCheck = mysqli_prepare($conn, "SELECT id FROM uporabnik WHERE (username = ? OR email = ?) AND id != ?");
        mysqli_stmt_bind_param($stmtCheck, "ssi", $username, $email, $id);
        mysqli_stmt_execute($stmtCheck);
        $obstojec = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCheck));

        if ($obstojec) {
            $napaka = "Username ali e-pošta že obstajata pri drugem članu.";
        } else {
            $stmt2 = mysqli_prepare($conn,
                "UPDATE uporabnik SET ime=?, priimek=?, username=?, email=?, vloga=?, datum_rojstva=?, aktiven=? WHERE id=?"
            );
            mysqli_stmt_bind_param($stmt2, "ssssssii", $ime, $priimek, $username, $email, $vloga, $datum_rojstva, $aktiven, $id);

            if (mysqli_stmt_execute($stmt2)) {
                $uspeh = "Član uspešno posodobljen!";
                $u["ime"]           = $ime;
                $u["priimek"]       = $priimek;
                $u["username"]      = $username;
                $u["email"]         = $email;
                $u["vloga"]         = $vloga;
                $u["datum_rojstva"] = $datum_rojstva;
                $u["aktiven"]       = $aktiven;
            } else {
                $napaka = "Napaka pri shranjevanju.";
            }
        }
    }

    if (empty($napaka) && !empty($_POST["novo_geslo"])) {
        $novoGeslo = $_POST["novo_geslo"];
        if (strlen($novoGeslo) < 6) {
            $napaka = "Novo geslo mora imeti vsaj 6 znakov.";
        } else {
            $hash = password_hash($novoGeslo, PASSWORD_DEFAULT);
            $stmtGeslo = mysqli_prepare($conn, "UPDATE uporabnik SET geslo_hash=? WHERE id=?");
            mysqli_stmt_bind_param($stmtGeslo, "si", $hash, $id);
            if (!mysqli_stmt_execute($stmtGeslo)) {
                $napaka = "Napaka pri spremembi gesla.";
            }
        }
    }
}