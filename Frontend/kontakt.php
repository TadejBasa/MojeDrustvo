<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,800&family=Roboto+Mono:ital,wght@0,330;1,330&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com/"></script>
  <link href="style.css" rel="stylesheet">
  <title>Kontakt-ŠD FERI</title>
</head>

<?php include 'header.php'; ?>

<section class="px-4 md:px-8 py-16 login-bg">

   <div class="grid lg:grid-cols-2 gap-10 items-start">

      <div>

         <div class="mb-12">
            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-3xl shadow-lg p-6">
               <h2 class="kontakt-naslov text-5xl md:text-6xl text-white mb-4">
                  Kontaktirajte nas
               </h2>

               <p class="text-xl text-white/90 leading-relaxed">
                  Za dodatne informacije, vprašanja ali sodelovanje ste vabljeni, da nas kontaktirate.
               </p>
            </div>
         </div>

         <div class="bg-white/95 rounded-2xl shadow-xl border border-white/40 p-8">

            <h3 class="kontakt-naslov text-4xl text-slate-900 mb-4">
               Kontaktni podatki
            </h3>

            <p class="text-slate-600 mb-8">
               Za vprašanja glede članstva, dogodkov ali sodelovanja nas lahko kontaktirate.
            </p>

            <div class="flex flex-col gap-5">

               <div class="flex items-start gap-4 p-5 rounded-xl bg-gradient-to-r from-violet-50 to-pink-50 border border-fuchsia-100 hover:shadow-md transition">
                  <div class="w-11 h-11 rounded-full bg-gradient-to-r from-violet-600 to-fuchsia-500 flex items-center justify-center text-white font-bold">
                     📍
                  </div>
                  <div>
                     <h3 class="text-slate-900 font-semibold">Naslov</h3>
                     <p class="text-sm text-slate-600 mt-1">
                        Koroška cesta 46, 2000 Maribor
                     </p>
                  </div>
               </div>

               <div class="flex items-start gap-4 p-5 rounded-xl bg-gradient-to-r from-violet-50 to-pink-50 border border-fuchsia-100 hover:shadow-md transition">
                  <div class="w-11 h-11 rounded-full bg-gradient-to-r from-violet-600 to-fuchsia-500 flex items-center justify-center text-white font-bold">
                     ☎
                  </div>
                  <div>
                     <h3 class="text-slate-900 font-semibold">Pokličite nas</h3>
                     <p class="text-sm text-slate-600 mt-1">
                        (02) 220 70 00
                     </p>
                  </div>
               </div>

               <div class="flex items-start gap-4 p-5 rounded-xl bg-gradient-to-r from-violet-50 to-pink-50 border border-fuchsia-100 hover:shadow-md transition">
                  <div class="w-11 h-11 rounded-full bg-gradient-to-r from-violet-600 to-fuchsia-500 flex items-center justify-center text-white font-bold">
                     ✉
                  </div>
                  <div>
                     <h3 class="text-slate-900 font-semibold">Pišite nam</h3>
                     <p class="text-sm text-slate-600 mt-1">
                        sportnodrustvoferi@gmail.com
                     </p>
                  </div>
               </div>

            </div>

         </div>

      </div>

      <div class="rounded-2xl overflow-hidden shadow-xl border border-white/40 bg-white/95 h-full">
         <div class="p-5 bg-gradient-to-r from-violet-600 via-fuchsia-500 to-pink-500">
            <h3 class="kontakt-naslov text-white text-3xl text-center">
               Kje se nahajamo
            </h3>
         </div>

         <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21946.236770061125!2d15.596919360557747!3d46.56194046219911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476f77afbd3903b1%3A0xed842395b6a24e1f!2sFAKULTETA%20ZA%20ELEKTROTEHNIKO%2C%20RA%C4%8CUNALNI%C5%A0TVO%20IN%20INFORMATIKO%20UNIVERZE%20V%20MARIBORU!5e0!3m2!1ssl!2ssi!4v1779660701648!5m2!1ssl!2ssi"
            class="w-full h-[818px] border-0"
            style="border:0;"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
         </iframe>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>