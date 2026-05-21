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
          
          <a href="index.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Domov</a>
          <a href="objave.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Dogodki</a>
          <a href="objave.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Novice</a>
          <a href="objave.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Obvestila</a>
          <a href="kontakt.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Kontakt</a>
        </div>
      </div>

      <div class="hidden md:flex items-center space-x-1 font-bold">
        <a href="login.php" class="py-2 px-3 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 hover:text-yellow-800 rounded transition duration-300">Prijava</a>
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