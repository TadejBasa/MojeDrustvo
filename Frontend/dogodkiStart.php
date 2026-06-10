<?php
require_once __DIR__ . '/../Backend/config.php';

$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM uporabnik WHERE vloga = 'admin' LIMIT 1"));
$kreator_id = $admin ? (int)$admin["id"] : 1;

$dogodki = [

    ["Nogometni turnir","Turnir v malem nogometu. Ekipe po 5+1, glavna nagrada malica v FERI EatSmart menzi.", "Ljudski vrt","2026-06-15 10:00:00",0, 36, "turnir","https://www.pendlesportswear.co.uk/blog/wp-content/uploads/goblet-and-soccer-ball-on-football-field-with-play-2024-11-17-11-44-39-utc-min.jpg"],
    ["Planinski pohod Pohorje","Skupinski pohod na Pohorje.","Maribor","2026-06-22 08:00:00",  5, 15, "pohod","https://www.visitmaribor.si/media/2886/lovrenska-jezera_maribor_pohorje_slovenija_slovenia_shutterstock_onixxino.jpg"],
    ["Košarkarski večer","Street-basket style, ekipe po 3.","Igrišče pri šoli","2026-07-01 18:00:00",  0, 18, "turnir","https://www.urbanmovement.info/wp-content/uploads/2021/07/AP-1WF2SW2KN2111_news-720x389.jpg"],
    ["Delavnica prve pomoči","Osnove prve pomoči.","FERI predavalnica Alfa", "2026-07-10 14:00:00",  0, 25, "delavnica","https://www.dnv.com/siteassets/images/16_7-basic-first-aid-training.jpg"],
    ["Izlet Murska Sobota","Enodnevni izlet.","Murska Sobota","2026-07-20 07:30:00", 10, 30, "izlet","https://www.visitmurskasobota.si/wp-content/uploads/2019/02/murska_sobota_1_.jpg"],
    ["Odbojkarski turnir","Poletni odbojkarski turnir - pari.","Mestni park","2026-08-05 10:00:00",  2, 24, "turnir","https://volleycountry.com/wp-content/uploads/2023/10/volleyball-tournaments-1080x675.jpg"],
    ["Namiznoteniški turnir","Enojno in dvojno. Loparje prinesete sami, žogice zagotovimo mi. Nagrada: bon za FERI restavracijo.","Dvorana Lukna","2026-09-06 10:00:00", 0, 16, "turnir","https://www.tabletenniscoach.me.uk/wp-content/uploads/2024/07/bh-flick.jpg"],
    ["Badmintonski turnir","Odpiramo novo badminton sekcijo z uvodnim turnirjem! Ekipe po 2, prijave do 5. septembra.","Dvorana Lukna","2026-09-12 14:00:00", 3, 20, "turnir","https://www.racquetpoint.com/cdn/shop/articles/badminton-the-ultimate-guide-to-the-racquet-sport-460186.jpg?v=1741601376&width=2048"],
    ["Pikado liga FERI","Večerna pikado liga — posamično. Trije krogi izločanja, finalna tekma z živo glasbo.","Štuk","2026-10-03 18:00:00", 2, 32, "turnir","https://upload.wikimedia.org/wikipedia/commons/f/fb/Darts_in_a_dartboard.jpg"],
    ["Pohod na Mariborsko Piramido","Lahkoten pohod po Mariborski Piramidi, primeren za vse starosti. Odhod izpred FERI.","Maribor","2026-07-05 09:00:00", 0, 20, "pohod","https://www.visitmaribor.si/media/5185/piramida_maribor_slovenija_sportida_2.jpg?anchor=center&mode=crop&width=1200&height=630"],
    ["Pohod Šmarna gora","Enodnevni izlet z vlakom v Ljubljano in pohod na Šmarno goro. Vrnitev pozno popoldne.","Ljubljana","2026-08-15 07:00:00", 8, 18, "pohod","https://www.caszaizlet.si/wp-content/uploads/2020/12/1-1.jpg"],
    ["Pohodniška tura Rogla","Pohod po markiranih poteh na Roglo z opazovanjem narave. Prevoz z avtobusem.","Rogla","2026-09-19 08:00:00", 12, 25, "pohod","https://www.vandraj.si/wp-content/uploads/2019/09/potmedkrosnjami-rogla-pohorje3.jpg"],
    ["Jesenski pohod Kozjak","Pohod čez Kozjak do koče Sv. Bolfenk z malico. Težavnost: srednja. Odhod izpred Dravograda.","Kozjak","2026-10-10 08:30:00", 5, 20, "pohod","https://www.soca-valley.com/img/2021010811123264/mid/sgs/Slap-Kozjak_-Hannes-Klausner-AdventuReal-Bovec.jpg?m=1610100754"],
    ["Zimski pohod Pohorje","Snežni pohod po Pohorju z izposojo snežnih krpelj. Kuhano vino v koči po pohodu.","Pohorje","2026-12-20 09:00:00", 15, 16, "pohod","https://old.delo.si/images/slike/picture/20170103/o_pohorje1_1024.jpg"],
    ["Delavnica fotografije","Osnove mobilne in DSLR fotografije na terenu. Prinesite svojo napravo.","FERI predavalnica alfa","2026-07-18 10:00:00", 0, 15, "delavnica","https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/Camponotus_flavomarginatus_ant.jpg/1280px-Camponotus_flavomarginatus_ant.jpg"],
    ["Delavnica prehrane za športnike","Profesionalna športnica bo razložila osnove prehrane pri vzdržljivostnih in ekipnih športih.","FERI predavalnica Beta","2026-08-22 14:00:00", 0, 30, "delavnica","https://upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg/1280px-Good_Food_Display_-_NCI_Visuals_Online.jpg"],
    ["Delavnica reševanja v gorah","Osnove orientacije, ravnanje ob nezgodi in klic reševalcev — v sodelovanju z GRS Maribor.","FERI predavalnica Alfa","2026-09-05 10:00:00", 0, 20, "delavnica","https://www.lepote-slovenije.si/wp-content/uploads/2018/12/julijske-alpe1.jpg"],
    ["Delavnica joge in raztezanja","Uvod v jogo za športnike — poudarek na regeneraciji in preprečevanju poškodb. Prinesite podlogo.","Dvorana Lukna","2026-09-27 09:00:00", 5, 20, "delavnica","https://www.heart.org/en/-/media/Images/News/2025/September-2025/Yoga_Brain_Health.jpg?sc_lang=en"],
    ["Delavnica taktike malega nogometa","Videoanaliza in taktična razprava s trenerjem Tadejem Bašo. Primerno za kapetane ekip.","FERI predavalnica Gama","2026-10-17 15:00:00", 0, 24, "delavnica","https://www.sport-tv.si/wp-content/uploads/2024/05/1030736573-scaled.jpg"],
    ["Izlet Piran","Enodnevni izlet na obalo — Piran in Portorož. Odhod ob 7:00, vrnitev pozno popoldne.","Piran","2026-08-01 07:00:00", 15, 35, "izlet","https://brunetteatsunset.com/wp-content/uploads/2025/12/DJI_0040-2.jpg"],
    ["Izlet Ptuj — staro mesto","Ogled starega mesta Ptuj z vodenim ogledom gradu. Vključena vstopnica za grad.","Ptuj","2026-09-13 09:00:00", 8, 28, "izlet","https://upload.wikimedia.org/wikipedia/commons/e/ec/Ptuj.jpg"],
    ["Izlet Terme Olimia","Sprostitveni izlet v terme Olimia. Vstopnine niso vključene, zagotovljen je le prevoz.","Olimje","2026-11-08 08:00:00", 10, 40, "izlet","https://www.terme-olimia.com/images/default-source/wellness-orhidelia/wellness-orhidelia-1920x1080/main-wellness-orhidelia-terme-olimia-273.jpg?sfvrsn=622cffa7_14"],
    ["Izlet Logarska dolina","Pohod in piknik v Logarski dolini.","Logarska dolina","2026-09-27 07:30:00", 12, 25, "izlet","https://www.slovenia.info/imagine_cache/mobile/uploads/znamenitosti/logar_valley_green.jpg"],
    ["Izlet Bled","Čolnarjenje na Blejskem jezeru in obisk gradu. Vstopnine za čolne in grad niso vključene.","Bled","2026-10-24 07:00:00", 10, 30, "izlet","https://brunetteatsunset.com/wp-content/uploads/2025/08/DJI_0877-1024x768.jpg"],
];

$stmt = mysqli_prepare($conn,
    "INSERT INTO dogodek (naslov, opis, lokacija, datum_cas, cena, st_mest, vrsta, slika_url, je_javen, kreator_id)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)"
);

$dodanih     = 0;
$preskocenih = 0;

foreach ($dogodki as $d) {
    [$naslov, $opis, $lokacija, $datum_cas, $cena, $st_mest, $vrsta, $slika_url] = $d;

    $obstaja = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT id FROM dogodek WHERE naslov = '" . mysqli_real_escape_string($conn, $naslov) . "' LIMIT 1")
    );

    if ($obstaja) {
        $preskocenih++;
        continue;
    }

    mysqli_stmt_bind_param($stmt, "ssssdissi",
        $naslov, $opis, $lokacija, $datum_cas, $cena, $st_mest, $vrsta, $slika_url, $kreator_id
    );
    mysqli_stmt_execute($stmt);
    $dodanih++;
}

echo "<p>Dodanih: <strong>$dodanih</strong></p>";
echo "<p><a href='../Frontend/dogodki.php'>Dogodki</a></p>";