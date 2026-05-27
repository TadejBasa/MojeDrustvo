
<!DOCTYPE html>
<html lang="sl">    
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
    <script src="trianglify.bundle.js"></script>
    <title>Prijava - Moje Društvo</title>
    <link href="style.css" rel="stylesheet">
    <script src="geslo.js" defer></script>
</head>
<body class="stran min-h-screen flex flex-col">

<?php include 'header.php';?>

<main class="login-bg flex-1 min-h-[110vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">Prijava</h2>
        <?php if(isset($_GET["napaka"])): ?>
          <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <?= htmlspecialchars($_GET["napaka"]) ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="../Backend/login.php" class="space-y-4">
            <div class="relative">
                <input type="text" name="vhod" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required value="<?= htmlspecialchars($_POST['vhod'] ?? '') ?>">
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                  Uporabniško ime ali email
                </label>
            </div>
            <div class="relative">
                <input type="password" id="geslo" name="geslo" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <button type="button" id="pokaziGeslo" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                  <img id="ikonaGeslo" src="slike/eye.png" class="w-5 h-5" alt="Pokaži geslo">
                </button>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                  Geslo
                </label>
              </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Prijava
            </button>
        </form>
        <hr class="my-6">
        <p class="text-center"> Nimaš računa?
            <a href="register.php" class="text-blue-600 font-semibold hover:underline">
              Registracija
            </a>
        </p>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>