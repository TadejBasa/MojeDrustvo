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
    <script src="geslo.js" defer></script>
    <script src="geslo_primerjava.js" defer></script>
    <title>Profil</title>
</head>
<body>

<?php include 'header.php';?>

<main class="login-bg flex-1 min-h-[110vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-10">
        <div class="flex flex-col items-center text-center mb-10">
            <form id="uploadForma" action="../Backend/objava_slik.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="jwt" id="jwtInput">
            <div class="relative mb-4">
                <img id="profilnaSlikaImg"src="slike/default.png" alt=" " class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                <label for="profilnaSlika" class="absolute bottom-0 right-0 bg-blue-600 text-white w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition">
                     + 
                </label>
                <input type="file" id="profilnaSlika" name="profilnaSlika" accept="image/*" class="hidden" onchange="document.getElementById('uploadForma').submit();">
            </div>
            </form>
            <h2 id="profilClana" class="text-4xl font-bold text-gray-800">
                Profil člana
            </h2>
        </div>
        <div id="prikazProfila">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="border rounded-lg p-3 h-20 hover:bg-gray-100 transition">
                    <p class="text-me text-gray-500">
                        Ime
                    </p>
                    <p id="ime" class="text-lg font-semibold text-gray-800"></p>
                </div>
                <div class="border rounded-xl p-3 h-20 hover:bg-gray-100 transition">
                    <p class="text-me text-gray-500">
                        Priimek
                    </p>
                    <p id="priimek" class="text-lg font-semibold text-gray-800"></p>
                </div>
                <div class="border rounded-xl p-3 h-20 hover:bg-gray-100 transition">
                    <p class="text-me text-gray-500">
                        Uporabniško ime
                    </p>
                    <p id="username" class="text-lg font-semibold text-gray-800"></p>
                </div>
                <div class="border rounded-lg p-3 h-20 hover:bg-gray-100 transition">
                    <p class="text-me text-gray-500">
                        Email
                    </p>
                    <p id="email" class="text-lg font-semibold text-gray-800"></p>
                </div>
            </div>
            <div class="mt-8 flex gap-4">
                <button type="button" id="urediProfil" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-fuchsia-500 text-fuchsia-600 shadow-md group">
                    <span class="absolute inset-0 bg-gradient-to-r from-violet-600 via-fuchsia-500 to-pink-500 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                    <span class="relative z-10 group-hover:text-white">
                        Uredi profil
                    </span>
                </button>
                <button type="button" id="spremeniGeslo" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-fuchsia-400 text-fuchsia-500 shadow-md group">
                    <span class="absolute inset-0 bg-gradient-to-r from-violet-400 via-fuchsia-300 to-pink-200 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                    <span class="relative z-10 group-hover:text-white">
                        Spremeni geslo
                    </span>
                </button>
            </div>
            <div class="mt-4">
                <a href="priljubljeniDogodki.php" class="block w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition text-center">
                    ♥ Priljubljeni dogodki
                </a>
            </div>
        </div>
        <div id="urejanjeProfila" style="display: none">
            <form action="../Backend/urejanje_profila.php" method="POST" class="space-y-4">
                <input type="hidden" name="jwt" id="jwtUredi">
                <h2 class="text-2xl font-bold text-gray-800">Urejanje profila</h2>
                <div class="relative">
                    <input type="text" id="novoIme" name="novoIme" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required value="<?= htmlspecialchars($_POST['ime'] ?? '') ?>">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Ime
                    </label>
                </div>
                <div class="relative">
                    <input type="text" id="novPriimek" name="novPriimek" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required value="<?= htmlspecialchars($_POST['priimek'] ?? '') ?>">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Priimek
                    </label>
                </div>
                <div class="relative">
                    <input type="text" id="novoUporabnisko" name="novoUporabnisko" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required value="<?= htmlspecialchars($_POST['priimek'] ?? '') ?>">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Uporabniško ime
                    </label>
                </div>
                <div id="nove_email" class="relative">
                    <input type="text" id="novEmail" name="novEmail" placeholder=" " class="peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required value="<?= htmlspecialchars($_POST['priimek'] ?? '') ?>">
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Email
                    </label>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-fuchsia-500 text-fuchsia-600 shadow-md group">
                        <span class="absolute inset-0 bg-gradient-to-r from-violet-600 via-fuchsia-500 to-pink-500 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                        <span class="relative z-10 group-hover:text-white">
                            Shrani
                        </span>
                    </button>
                    <button type="button" id="prekliciUredi" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-violet-300 text-violet-500 shadow-md group">
                        <span class="absolute inset-0 bg-gradient-to-r from-violet-300 via-fuchsia-300 to-pink-300 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                        <span class="relative z-10 group-hover:text-white">
                            Prekliči
                        </span>
                    </button>
                </div>
            </form>
        </div>
        <div id="spremembaGesla" style="display: none">
            <?php if(isset($_GET["napaka"])): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                    <?= htmlspecialchars($_GET["napaka"]) ?>
                </div>
            <?php endif; ?>
            <form action="../Backend/primerjava_gesel.php" method="POST" class="space-y-4">
                <input type="hidden" name="jwt" id="jwtGeslo">
                <div class="relative">
                    <input type="password" id="trenutnoGeslo" name="trenutnoGeslo" placeholder=" " class="geslo-input peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                    <button type="button" class="pokaziGeslo absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <img src="slike/eye.png" class="ikonaGeslo w-5 h-5" alt="Pokaži geslo">
                    </button>
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Trenutno geslo
                    </label>
                </div>
                <div class="relative">
                    <input type="password" id="novoGeslo" name="novoGeslo" placeholder=" " class="geslo-input peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                    <button type="button" class="pokaziGeslo absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <img src="slike/eye.png" class="ikonaGeslo w-5 h-5" alt="Pokaži geslo">
                    </button>
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Novo geslo
                    </label>
                </div>
                <div class="relative">
                    <input type="password" id="potrdiGeslo" name="potrdiGeslo" placeholder=" " class="geslo-input peer pt-6 w-full border rounded-lg px-3 pb-2 h-14 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                    <button type="button" class="pokaziGeslo absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <img src="slike/eye.png" class="ikonaGeslo w-5 h-5" alt="Pokaži geslo">
                    </button>
                    <label class="text-gray-500 pointer-events-none absolute left-3 top-4 transition-all duration-200 peer-focus:text-sm peer-focus:top-1 peer-valid:text-sm peer-valid:top-1">
                        Potrdi novo geslo
                    </label>
                </div>
                <div class="flex gap-4">
                    <button type="submit" id="shraniGeslo" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-fuchsia-500 text-fuchsia-600 shadow-md group">
                        <span class="absolute inset-0 bg-gradient-to-r from-violet-600 via-fuchsia-500 to-pink-500 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                        <span class="relative z-10 group-hover:text-white">
                            Shrani
                        </span>
                    </button>
                    <button type="button" id="prekliciGeslo" class="relative overflow-hidden w-full p-3 rounded-lg border-2 border-violet-300 text-violet-500 shadow-md group">
                        <span class="absolute inset-0 bg-gradient-to-r from-violet-300 via-fuchsia-300 to-pink-300 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                        <span class="relative z-10 group-hover:text-white">
                            Prekliči
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
function nalagajProfil() {

    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("jwtGeslo").value = sessionStorage.getItem("jwt");
    });

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

        if (uporabnik.vrsta_prijave === "google") {
            document.getElementById("nove_email").style.display = "none";
        }

        document.getElementById("ime").textContent = uporabnik.ime;
        document.getElementById("priimek").textContent = uporabnik.priimek;
        document.getElementById("username").textContent = uporabnik.username;
        document.getElementById("email").textContent = uporabnik.email;
        document.getElementById("novoIme").value = uporabnik.ime;
        document.getElementById("novPriimek").value = uporabnik.priimek;
        document.getElementById("novoUporabnisko").value = uporabnik.username;
        document.getElementById("novEmail").value = uporabnik.email;
        document.getElementById("jwtGeslo").value = sessionStorage.getItem("jwt");
        document.getElementById("jwtInput").value = sessionStorage.getItem("jwt");
        document.getElementById("jwtUredi").value = sessionStorage.getItem("jwt");

        if (uporabnik.profilna_slika) {
            document.getElementById("profilnaSlikaImg").src = uporabnik.profilna_slika + "?v=" + Date.now();
        }

        document.getElementById("jwtInput").value = sessionStorage.getItem("jwt");
    });
}

if (sessionStorage.getItem("jwt")) {
    nalagajProfil();
} else {
    setTimeout(nalagajProfil, 200);
}
document.getElementById("jwtGeslo").value = sessionStorage.getItem("jwt");

setTimeout(() => {
    if (new URLSearchParams(window.location.search).get("geslo") === "1") {
        document.getElementById("prikazProfila").style.display = "none";
        document.getElementById("urejanjeProfila").style.display = "none";
        document.getElementById("spremembaGesla").style.display = "block";
    }
}, 100);

document.getElementById("jwtUredi").value = sessionStorage.getItem("jwt");
document.getElementById("jwtInput").value = sessionStorage.getItem("jwt");
</script>
    
</body>
</html>