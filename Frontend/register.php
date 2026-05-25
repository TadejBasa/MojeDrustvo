<?php
session_start();
require_once 'config.php';

if (isset($_SESSION["uporabnik_id"])) {
    header("Location: index.php");
    exit();
}

$napaka = "";
$uspeh = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = trim($_POST["ime"]);
    $priimek = trim($_POST["priimek"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $geslo = $_POST["geslo"];
    $datum_rojstva = $_POST["datum_rojstva"];

    $geslo_hash = password_hash($geslo, PASSWORD_DEFAULT);
    $vloga = "clan";

    $sql = "INSERT INTO uporabnik
    (ime, priimek, username, email, geslo_hash, vloga, datum_rojstva)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $ime,
        $priimek,
        $username,
        $email,
        $geslo_hash,
        $vloga,
        $datum_rojstva
    );

    if(mysqli_stmt_execute($stmt)){
      $uspeh = "Registracija uspešna";
    }else{
      $napaka = "Napaka pri registraciji";
    }

    $uspeh = "Registracija uspešna";
}
?>

<!DOCTYPE html>
<html class="html" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Solitreo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <script src="trianglify.bundle.js"></script><title>Prijava - Moje Društvo</title>
    <link href="style.css" rel="stylesheet">
    <script src="geslo.js" defer></script>
    <title>Registracija - Moje Društvo</title>
</head>
<body class="stran html">

<?php include 'header.php'; ?>

<main class="login-bg flex-1 min-h-[110vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">
            Registracija
        </h2>
        <?php if ($uspeh): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                <?= htmlspecialchars($uspeh) ?>
            </div>
        <?php endif; ?>
        <form id="registracijaForm" method="POST" action="register.php" class="space-y-4">
            <div class="relative">
                <input type="text" id="ime" name="ime" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                    Ime
                </label>
            </div>
            <div class="relative">
                <input type="text" id="priimek" name="priimek" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                    Priimek
                </label>
            </div>
            <div class="relative">
                <input type="text" id="uporabniskoIme" name="username" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                    Uporabniško ime
                </label>
            </div>
            <div class="relative">
                <input type="email" id="email" name="email" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                    Email
                </label>
            </div>
            <div class="relative">
                <input type="password" id="geslo" name="geslo" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <button type="button" id="pokaziGeslo" class="absolute right-3 top-1/2 -translate-y-1/2">
                    <img id="ikonaGeslo" src="slike/eye.png" class="w-5 h-5" alt="Pokaži geslo">
                </button>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                    Geslo
                </label>
            </div>
            <div class="relative">
                <input type="date" id="datumRojstva" name="datum_rojstva" class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-1 text-sm">
                    Datum rojstva
                </label>
            </div>
            <button type="submit"
            class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Registracija
            </button>
        </form>
        <hr class="my-6">
        <p class="text-center">
            Že imaš račun?
            <a href="login.php" class="text-blue-600 font-semibold hover:underline">
                Prijava
            </a>
        </p>
    </div>
</main>

<?php include 'footer.php'; ?>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="registracija.js" defer></script>
</html>