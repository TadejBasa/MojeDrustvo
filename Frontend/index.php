<?php session_start();?>
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
    <link rel="stylesheet" href="style.css">
    <title>Zacetna stran</title>
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

  // $_SESSION["uporabnik_id"] = 1;
}

include 'header.php';
?>

<section class="welcome flex flex-col items-center">
  <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl shadow-lg p-6">
    <div class="welcome-vsebina flex items-center gap-4">
      <h1>ŠPORTNO DRUŠTVO FERI ⚽</h1>
    </div>
    <p>Pridružite se največjemu športnemu društvu na Mariborski univerzi!</p>
  </div>
  <div>
    <button onclick = "location.href = 'register.php'" class="btn-glow">Pridruži se nam!</button>
  </div>
</section>

<div class="slider">
	<div class="slide-track">
		<div class="slide">
			<img src="https://www.elektro-maribor.si/media/5605/em_dd_logo_ver_duo_rgb.jpg" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://sd-sanacije.si/wp-content/uploads/2014/09/Logo-color-Sava.jpg-RGB_1.jpg" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://www.automotivetestingtechnologyinternational.com/wp-content/uploads/2021/01/dewesoft-logo-2.png" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://www.elektro-celje.si/si/files/default/EL_Celje/Mediji/Logotipi%20in%20ostalo%20gradivo/ElektroCelje_CGP_LOGO_horizontal-01.png" height="100" width="250" alt="" />
		</div>
		<div class="slide" style = "margin-right: 50px">
			<img src="https://www.ligna.de/apollo/ligna_2025/obs/Grafik/A1410895/LOG_DE0_1410895_4973817.png.png" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://epik-prihodnost.si/uploads/7691c5b9395d2d6300e8e855f6dd1226/geni-logo.png" height="100" width="250" alt="" />
		</div>
		<div class="slide" style = "margin-left: 120px">
			<img src="https://www.acs-giz.si/wp-content/uploads/2025/07/FERI_logo-feri-brez-napisa-moder_a.png" height="100" width="250" alt="" />
		</div>
    <div class="slide">
			<img src="https://www.elektro-maribor.si/media/5605/em_dd_logo_ver_duo_rgb.jpg" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://sd-sanacije.si/wp-content/uploads/2014/09/Logo-color-Sava.jpg-RGB_1.jpg" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://www.automotivetestingtechnologyinternational.com/wp-content/uploads/2021/01/dewesoft-logo-2.png" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://www.elektro-celje.si/si/files/default/EL_Celje/Mediji/Logotipi%20in%20ostalo%20gradivo/ElektroCelje_CGP_LOGO_horizontal-01.png" height="100" width="250" alt="" />
		</div>
		<div class="slide" style = "margin-right: 50px">
			<img src="https://www.ligna.de/apollo/ligna_2025/obs/Grafik/A1410895/LOG_DE0_1410895_4973817.png.png" height="100" width="250" alt="" />
		</div>
		<div class="slide">
			<img src="https://epik-prihodnost.si/uploads/7691c5b9395d2d6300e8e855f6dd1226/geni-logo.png" height="100" width="250" alt="" />
		</div>
		<div class="slide" style = "margin-left: 120px">
			<img src="https://www.acs-giz.si/wp-content/uploads/2025/07/FERI_logo-feri-brez-napisa-moder_a.png" height="100" width="250" alt="" />
		</div>
	</div>
</div>
<div class="fade-bottom"></div>
<section class="opis">
  <div class="flex flex-col p-8 w-full mx-auto md:flex-row" style="max-width: 90%;" data-aos="fade-up">
      <div class="flex flex-col md:p-6 leading-normal flex-1">
          <h5 class="naslovOpis mb-6 text-8xl font-bold tracking-tight text-gray-800 leading-tight">O DRUŠTVU</h5>
          <div class="flex flex-col justify-center gap-4">
              <p class="text-4xl text-white leading-relaxed font-medium mt-8 opisBesedilo">Športno društvo FERI je študentska organizacija, ki združuje študente 
                                                            Fakultete za elektrotehniko, računalništvo in informatiko v Mariboru. 
                                                            Naš cilj je spodbujati športno aktivnost, zdravi način življenja in 
                                                            športni duh med študenti. Organiziramo različne športne dogodke, 
                                                            tekmovanja in rekreativne aktivnosti skozi vse leto. Pridruži se nam 
                                                            in postani del naše rastoče skupnosti!</p>
          </div>
      </div>
      <div class="w-full md:w-1/2 mt-4 md:mt-0">
          <img class="object-cover w-full h-56 md:h-full rounded-xl" src="https://feri.um.si/site/assets/files/11467/2__meduniverzitetno_sportno_tekmovanje_79_of_152_-min.jpg" alt="">
      </div>
  </div>
</section>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-8 pb-16 text-center" style="max-width: 70%; margin: 6rem auto 0rem auto;" data-aos="flip-down">
  <div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="gridNaslov text-4xl mb-3 ">Več kot 10 oddelkov</h3>
    <hr class="mb-4">
    <p class="opisBesedilo text-gray-600 leading-relaxed text-2xl">Ponujamo več kot 10 različnih športnih sekcij — od nogometa in košarke do plezanja in joge. Vsak najde svojo aktivnost.</p>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="gridNaslov text-4xl mb-3 ">500+ aktivnih članov</h3>
    <hr class="mb-4">
    <p class="opisBesedilo text-gray-600 leading-relaxed text-2xl">Spoznaj nove prijatelje in postani del živahne skupnosti 500+ aktivnih študentov. Skupaj gradimo prijetno vzdušje na fakulteti.</p>
  </div>

  <div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="gridNaslov text-4xl mb-3">Dogodki skozi celo leto</h3>
    <hr class="mb-4">
    <p class="opisBesedilo text-gray-600 leading-relaxed text-2xl">Skozi vse leto organiziramo tekmovanja, izlete, delavnice in družabne večere. Vedno se dogaja nekaj zanimivega.</p>
  </div>
</div> 
<div class="galerija">
    <img id="glavna-slika" src="https://feri.um.si/site/assets/files/9709/feri_finale_web-5.jpg" alt="Slika 1">
 
    <img src="https://feri.um.si/site/assets/files/9709/feri_finale_web-5.jpg" alt="Slika 1" class="slicicica aktivna" onclick="zamenjaj(this)">
    <img src="https://feri.um.si/site/assets/files/11467/2__meduniverzitetno_sportno_tekmovanje_23_of_152_-min.jpg" alt="Slika 2" class="slicicica" onclick="zamenjaj(this)">
    <img src="https://feri.um.si/site/assets/files/9709/feri_finale_web-8.jpg" alt="Slika 3" class="slicicica" onclick="zamenjaj(this)">
    <img src="https://feri.um.si/site/assets/files/11467/2__meduniverzitetno_sportno_tekmovanje_48_of_152_-min.jpg" alt="Slika 4" class="slicicica" onclick="zamenjaj(this)">
    <img src="https://feri.um.si/site/assets/files/11467/2__meduniverzitetno_sportno_tekmovanje_145_of_152_-min.jpg" alt="Slika 5" class="slicicica" onclick="zamenjaj(this)">
    <img src="https://feri.um.si/site/assets/files/9709/feri_finale_web-7.jpg" alt="Slika 6" class="slicicica" onclick="zamenjaj(this)">
</div>
<div class="flex justify-center mb-8 mt-12">
    <button onclick="location.href='register.php'" class="btn-glow2">Pridruži se ekipi!</button>
</div>

<script src="galerija.js"></script>





<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<script src="script.js"></script>
</body>
</html>