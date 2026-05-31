
<footer class="bg-gray-100">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
              <a href="#" class="flex items-center">
                  <img src="slike/sd_feri_logo.jpg" class="h-16 me-3" alt="ŠD FERI logo" />
                  <span class="text-gray-700 text-heading self-center text-2xl font-semibold whitespace-nowrap">ŠD FERI</span>
              </a>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-heading text-gray-900 uppercase">objave</h2>
                    <ul class="text-gray-700 font-semibold space-y-3">
                      <li>
                          <a href="#" class="footer-link">Dogodki</a>
                      </li>
                      <li>
                          <a href="#" class="footer-link">Novice</a>
                      </li>
                      <li>
                          <a href="#" class="footer-link">Obvestila</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-heading text-gray-900 uppercase">Navigacija</h2>
                  <ul class="text-body font-semibold">
            
            <?php if (isset($_SESSION["uporabnik_id"])): ?>

                <li class="mb-4">
                    <a href="#" class="footer-link">Moj račun</a>
                </li>
                
            <?php else: ?>

            <li class="mb-4">
                <a href="#" class="footer-link">Prijava</a>
            </li>

            <?php endif; ?>

                      <li>
                          <a href="#" class="footer-link">Domov</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-heading text-gray-900 uppercase">koristno</h2>
                  <ul class="text-body font-semibold">
                      <li class="mb-4">
                          <a href="#" class="footer-link">Pogoji poslovanja</a>
                      </li>
                      <li>
                          <a href="#" class="footer-link">Kontakt</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-default sm:mx-auto lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-body sm:text-center">© 2026 <a href="#" class="hover:underline">Športno društvo Fakultete za elektrotehniko, računalništvo in informatiko™</a>. Vse pravice pridržane.</span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">

            <a href="#" class="text-body hover:text-heading">
                <span class="sr-only">Facebook</span>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z" clip-rule="evenodd"/>
                </svg>
            </a>

            <a href="#" class="text-body hover:text-heading ms-5">
                <span class="sr-only">Instagram</span>

                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9A5.5 5.5 0 0 1 16.5 22h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2Zm9 2h-9A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.25-.9a1.15 1.15 0 1 1-2.3 0 1.15 1.15 0 0 1 2.3 0Z"/>
                </svg>
            </a>

            <a href="#" class="text-body hover:text-heading ms-5 transition" target="_blank">
                <span class="sr-only">FERI website</span>

                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm8 10h-3a12.7 12.7 0 0 0-1.6-6A8 8 0 0 1 20 12Zm-8-8a10.5 10.5 0 0 1 2.5 8H9.5A10.5 10.5 0 0 1 12 4Zm-2.5 10h5A10.5 10.5 0 0 1 12 20a10.5 10.5 0 0 1-2.5-6ZM4 12h3a12.7 12.7 0 0 0 1.6 6A8 8 0 0 1 4 12Zm5.5-8A12.7 12.7 0 0 0 8 10H4a8 8 0 0 1 5.5-6Z"/>
                </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
