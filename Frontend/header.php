
<nav class="bg-gray-100">
  <div class="max-w-6xl mx-auto px-4">
    <div class="flex justify-between">

      <div class="flex space-x-4">

        <div>
          <a href="index.php" class="flex items-center py-6 px-3 text-gray-700 hover:text-gray-900">
            <img src="slike/sd_feri_logo.jpg"
              alt="ŠD FERI"
              class="h-24 w-auto"></a>
        </div>

        <div class="hidden md:flex items-center space-x-1 font-bold">
          <a href="index.php" class="nav-link">Domov</a>
          <a href="dogodki.php" class="nav-link">Dogodki</a>
          <a href="objave.php" class="nav-link">Obvestila</a>
          <a href="kontakt.php" class="nav-link">Kontakt</a>
        </div>
      </div>

    <div class="hidden md:flex items-center space-x-3 font-bold">

    <span id="navUsername" class="text-gray-700 hidden"></span>

      <a id="navAdmin" href="admin.php"
      class="hidden py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-md transition duration-300">Admin</a>

      <a id="navProfil" href="profil.php"
        class="hidden relative overflow-hidden px-3 py-2
        border-2 border-emerald-500 text-emerald-600 rounded-full shadow-md group">

        <span class="absolute inset-0 bg-emerald-500 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>

        <span class="relative z-10 group-hover:text-white">Profil</span>
      </a>

      <a id="navOdjava" href="odjava.php"
        class="hidden relative overflow-hidden px-3 py-2 border-2 border-red-500 text-red-600 rounded-full shadow-md group">

        <span class="absolute inset-0 bg-red-500 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>

        <span class="relative z-10 group-hover:text-white">Odjava</span>
      </a>

      <a id="navPrijava" href="login.php" class="py-2 px-3 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 hover:text-yellow-800 rounded transition duration-300">
          Prijava
      </a>

    </div>

      <!-- mobile button goes here -->
      <div class="md:hidden flex items-center">
        <button class="mobile-menu-button">
          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

    </div>
  </div>

  <!-- mobile menu -->
  <div class="mobile-menu hidden md:hidden">
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Domov</a>
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Dogodki</a>
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Obvestila</a>
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Kontakt</a>
  </div>
</nav>

<script>
function decodeJWT(token) {
    try {
        const payload = token.split(".")[1];
        return JSON.parse(atob(payload));
    } catch (e) {
        return null;
    }
}

const navPrijava = document.getElementById("navPrijava");
const navProfil = document.getElementById("navProfil");
const navAdmin = document.getElementById("navAdmin");
const navOdjava = document.getElementById("navOdjava");
const navUsername = document.getElementById("navUsername");

const navToken = sessionStorage.getItem("jwt");

if (navToken) {

    const uporabnik = decodeJWT(navToken);

    navPrijava.classList.add("hidden");

    navProfil.classList.remove("hidden");
    navOdjava.classList.remove("hidden");
    navUsername.classList.remove("hidden");

    navUsername.textContent = uporabnik.username;

    if (uporabnik.vloga === "admin") {
        navAdmin.classList.remove("hidden");
    }

} else {

    navPrijava.classList.remove("hidden");

    navProfil.classList.add("hidden");
    navAdmin.classList.add("hidden");
    navOdjava.classList.add("hidden");
    navUsername.classList.add("hidden");
}
</script>