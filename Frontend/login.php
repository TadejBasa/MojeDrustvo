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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<script>
function googleLogin(response) {
    fetch("../Backend/google_login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            credential: response.credential
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            sessionStorage.setItem("jwt", data.token);
            window.location.href = "profil.php";
        } else {
            alert(data.napaka || "Google prijava ni uspela.");
        }
    });
}
</script>

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
                <input type="text" name="vhod" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required value="<?= htmlspecialchars($_POST['vhod'] ?? '') ?>">
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                  Uporabniško ime ali email
                </label>
            </div>
            <div class="relative">
                <input type="password" name="geslo" placeholder=" " class="geslo geslo-input peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                <button type="button" class="pokaziGeslo absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                  <img src="slike/eye.png" class="ikonaGeslo w-5 h-5" alt="Pokaži geslo">
                </button>
                <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                  Geslo
                </label>
              </div>
            <button type="submit" class="w-full bg-fuchsia-600 text-white p-3 rounded-lg hover:bg-fuchsia-700 transition">
                Prijava
            </button>
        </form>
        <hr class="my-6">
        <div id="g_id_onload" data-client_id="624964479245-cnjesbkvicibe8mf18n5iicd1hh7qg7u.apps.googleusercontent.com" data-callback="googleLogin"></div>
        <div class="flex justify-center">
            <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="signin_with" data-shape="rectangular" data-width="400"></div>
        </div>
        <hr class="my-6">
        <p class="text-center"> Nimaš računa?
            <a href="register.php" class="text-fuchsia-600 font-semibold hover:underline">
              Registracija
            </a>
        </p>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>