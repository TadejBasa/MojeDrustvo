<script>
    const token = sessionStorage.getItem("jwt");
    if (!token) {
        window.location.href = "login.php";
    }
</script>

<!DOCTYPE html>
<html lang="en">
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
    <link href="style.css" rel="stylesheet">
    <script src="profil.js" defer></script>
    <title>Profil</title>
</head>
<body>

<?php include 'header.php';?>

<main class="login-bg flex-1 min-h-[110vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-10">
        <div class="flex flex-col items-center text-center mb-10">
            <div class="relative mb-4">
                <img src="slike/default-profile.png" alt=" " class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                <label for="profilnaSlika" class="absolute bottom-0 right-0 bg-blue-600 text-white w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition">
                     +
                </label>
                <input type="file" id="profilnaSlika" name="profilnaSlika" accept="image/*" class="hidden">
            </div>
            <h2 class="text-4xl font-bold text-gray-800">
                Profil člana
            </h2>
        </div>
        <div id="prikazProfila">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="border rounded-xl p-5 hover:bg-gray-100 transition">
                <p class="text-me text-gray-500">
                    Ime
                </p>
                <p id="ime" class="text-lg font-semibold text-gray-800"></p>
            </div>
            <div class="border rounded-xl p-5 hover:bg-gray-100 transition">
                <p class="text-me text-gray-500">
                    Priimek
                </p>
                <p id="priimek" class="text-lg font-semibold text-gray-800"></p>
            </div>
            <div class="border rounded-xl p-5 hover:bg-gray-100 transition">
                <p class="text-me text-gray-500">
                    Uporabniško ime
                </p>
                <p id="username" class="text-lg font-semibold text-gray-800"></p>
            </div>
            <div class="border rounded-xl p-5 hover:bg-gray-100 transition">
                <p class="text-me text-gray-500">
                    Datum rojstva
                </p>
                <p id="datum_rojstva" class="text-lg font-semibold text-gray-800"></p>
            </div>
            <div class="border rounded-xl p-5 hover:bg-gray-100 transition">
                <p class="text-me text-gray-500">
                    Status prijave: 
                </p>
                <p id="status" class="text-lg font-semibold text-gray-800"></p>
            </div>
        </div>
        <div id="urejanjeProfila" class="hidden mt-6">
            <form class="space-y-4">
                <div class="relative">
                    <input type="text" value="Tadej" class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Ime
                    </label>
                </div>
                <div class="relative">
                    <input type="text" value="Basa" class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Priimek
                    </label>
                </div>
                <div class="relative">
                    <input type="text" value="LilTadaX" class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Uporabniško ime
                    </label>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                        Shrani
                    </button>
                    <button type="button" id="preklici" class="w-full border border-gray-300 p-3 rounded-lg hover:bg-gray-100 transition">
                        Prekliči
                    </button>
                </div>
            </form>
        </div>
        <div class="mt-8 flex gap-4">
            <button type="button" id="urediProfil" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Uredi profil
            </button>
            <button type="button" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                Spremeni geslo
            </button>
        </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
function nalagajProfil() {
    const token = sessionStorage.getItem("jwt");
    if (!token) {
        window.location.href = "login.php";
        return;
    }
    fetch("../Backend/profil.php", {
        headers: {
            "Authorization": "Bearer " + token
        }
    })
    .then(res => {
        if (!res.ok) {
            sessionStorage.removeItem("jwt");
            window.location.href = "login.php";
            return;
        }
        return res.json();
    })
    .then(uporabnik => {
        if (!uporabnik) return;
        document.getElementById("ime").textContent = uporabnik.ime;
        document.getElementById("priimek").textContent = uporabnik.priimek;
        document.getElementById("username").textContent = uporabnik.username;
        document.getElementById("datum_rojstva").textContent = uporabnik.datum_rojstva;
    });
}

// Počakaj da se sessionStorage naloži (pomembno po preusmeritvi iz login)
if (sessionStorage.getItem("jwt")) {
    nalagajProfil();
} else {
    setTimeout(nalagajProfil, 200);
}
</script>
    
</body>
</html>