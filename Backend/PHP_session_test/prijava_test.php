<?php
session_start();
require_once 'config.php';

if (isset($_SESSION["uporabnik_id"])) {
    header("Location: index.php");
    exit();
}

$napaka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vhod  = trim($_POST["vhod"]);
    $geslo = $_POST["geslo"];

    if (empty($vhod) || empty($geslo)) {
        $napaka = "Prosim izpolni vsa polja.";
    } else {
        $sql  = "SELECT * FROM uporabnik WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $vhod, $vhod);
        mysqli_stmt_execute($stmt);

        $rezultat  = mysqli_stmt_get_result($stmt);
        $uporabnik = mysqli_fetch_assoc($rezultat);

        if ($uporabnik && password_verify($geslo, $uporabnik["geslo_hash"])) {
            session_regenerate_id(true);

        $_SESSION["uporabnik_id"] = $uporabnik["id"];
        $_SESSION["ime"]          = $uporabnik["ime"];
        $_SESSION["username"]     = $uporabnik["username"];
        $_SESSION["vloga"]        = $uporabnik["vloga"];

        $redirect = ($uporabnik["vloga"] == "admin")
            ? "admin.php"
            : "index.php";

            echo "
                <script>
                    sessionStorage.setItem('uporabnik_id', '{$uporabnik["id"]}');
                    sessionStorage.setItem('ime', '" . addslashes($uporabnik["ime"]) . "');
                    sessionStorage.setItem('username', '" . addslashes($uporabnik["username"]) . "');
                    sessionStorage.setItem('vloga', '" . addslashes($uporabnik["vloga"]) . "');
                    window.location.href = '$redirect';
                </script> ";
            exit();        
        } else {
            $napaka = "Napačno uporabniško ime/email ali geslo.";
        }
    }
}
?>