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
          <a href="objave.php" class="nav-link">Novice</a>
          <a href="objave.php" class="nav-link">Obvestila</a>
          <a href="kontakt.php" class="nav-link">Kontakt</a>
        </div>
      </div>

      <div class="hidden md:flex items-center space-x-3 font-bold">

<?php if (isset($_SESSION["uporabnik_id"])): ?>

  <div class="relative">

    <button id="profileButton">
      <img
        src="slike/deafult_user.jpg"
        alt="Profil"
        class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 hover:border-slate-500 transition"
      >
    </button>

    <div id="profileMenu"
      class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">

      <a href="profil.html"
        class="block px-4 py-2 hover:bg-gray-100">
        Moj račun
      </a>

      <a href="#"
        class="block px-4 py-2 hover:bg-gray-100">
        Moji dogodki
      </a>

      <hr class="my-2">

      <a href="logout_success.php"
        class="block px-4 py-2 text-red-600 hover:bg-red-50">
        Odjava
      </a>

    </div>

  </div>

<?php else: ?>

  <!-- LOGIN -->
  <a href="login.php"
    class="py-2 px-3 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 hover:text-yellow-800 rounded transition duration-300">
    Prijava
  </a>

<?php endif; ?>

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
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Novice</a>
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Obvestila</a>
    <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-200">Kontakt</a>
  </div>
</nav>