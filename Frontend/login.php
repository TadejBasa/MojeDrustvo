<?php
session_start();
require_once 'config.php';

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
            $_SESSION["uporabnik_id"] = $uporabnik["id"];
            $_SESSION["ime"]          = $uporabnik["ime"];
            $_SESSION["username"]     = $uporabnik["username"];
            $_SESSION["vloga"]        = $uporabnik["vloga"];

            if ($uporabnik["vloga"] == "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $napaka = "Napačno uporabniško ime/email ali geslo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Prijava - Moje Društvo</title>
</head>
<body class="stran min-h-screen flex flex-col bg-[url('slike/test_wawe.svg')] bg-cover bg-center">

<?php include 'header.php';?>

<main class="flex-1 min-h-[110vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center mb-6">Prijava</h2>
        <?php if ($napaka): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                <?= htmlspecialchars($napaka) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label class="block mb-2 font-medium">Uporabniško ime ali email</label>
                <input type="text" name="vhod" class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500" required value="<?= htmlspecialchars($_POST['vhod'] ?? '') ?>">
            </div>
            <div>
                <label class="block mb-2 font-medium">Geslo</label>
                <input type="password" name="geslo" class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 transition">
                Prijava
            </button>
        </form>
        <hr class="my-6">
        <p class="text-center"> Nimaš računa?
            <a href="register.php" class="text-green-600 font-semibold hover:underline">
              Registracija
            </a>
        </p>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>