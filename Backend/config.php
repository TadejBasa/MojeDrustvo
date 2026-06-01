<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "mojedrustvo";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
}
$dogodkiStart = [
    ["Nogometni turnir", "Turnir v malem nogometu. Ekipe po 5+1, glavna nagrada malica v FERI EatSmart menzi.", "Ljudski vrt", "2026-06-15 10:00:00", 0, 36, "turnir", "https://www.pendlesportswear.co.uk/blog/wp-content/uploads/goblet-and-soccer-ball-on-football-field-with-play-2024-11-17-11-44-39-utc-min.jpg"],
    ["Planinski pohod Pohorje", "Skupinski pohod na Pohorje.", "Maribor", "2026-06-22 08:00:00", 5, 15, "pohod", "https://www.visitmaribor.si/media/2886/lovrenska-jezera_maribor_pohorje_slovenija_slovenia_shutterstock_onixxino.jpg"],
    ["Košarkarski večer", "Street-basket style, ekipe po 3.", "Igrišče pri šoli", "2026-07-01 18:00:00", 0, 18, "turnir", "https://www.urbanmovement.info/wp-content/uploads/2021/07/AP-1WF2SW2KN2111_news-720x389.jpg"],
    ["Delavnica prve pomoči", "Osnove prve pomoči.", "FERI predavalnica Alfa", "2026-07-10 14:00:00", 0, 25, "delavnica", "https://www.dnv.com/siteassets/images/16_7-basic-first-aid-training.jpg"],
    ["Izlet Murska Sobota", "Enodnevni izlet.", "Murska Sobota", "2026-07-20 07:30:00", 10, 30, "izlet", "https://www.visitmurskasobota.si/wp-content/uploads/2019/02/murska_sobota_1_.jpg"],
    ["Odbojkarski turnir", "Poletni odbojkarski turnir -pari.", "Mestni park", "2026-08-05 10:00:00", 2, 24, "turnir", "https://volleycountry.com/wp-content/uploads/2023/10/volleyball-tournaments-1080x675.jpg"],
];
$admin_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM uporabnik WHERE vloga = 'admin' LIMIT 1"));
$kreator_id = $admin_row ? (int)$admin_row["id"] : 0;
if ($kreator_id > 0) {
    foreach ($dogodkiStart as $s) {
        $obstaja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM dogodek WHERE naslov = '$s[0]'"));
        if (!$obstaja) {
            mysqli_query($conn, "INSERT INTO dogodek (naslov, opis, lokacija, datum_cas, cena, st_mest, vrsta, slika_url ,je_javen, kreator_id) 
                                 VALUES ('$s[0]', '$s[1]', '$s[2]', '$s[3]', $s[4], $s[5], '$s[6]','$s[7]', 1, $kreator_id)");
        }
    }
}
$objaveStart = [
    [
        "Dobrodošli v društvu!",
        "Pozdravljeni vsi novi in stari člani. Veseli smo, da ste del naše skupnosti. V prihodnosti nas čaka veliko zanimivih dogodkov, delavnic in izletov. Ostanite z nami!",
        "novica",
        1, 1, 2
    ],
    [
        "Letni program 2026 je objavljen",
        "Pripravili smo bogat program za leto 2026. Na sporedu so pohodi, turnirji, delavnice in izleti. Vse podrobnosti najdete v razdelku Dogodki. Zgodnja prijava je priporočljiva, saj so mesta omejena!",
        "novica",
        1, 0, 2
    ],
    [
        "Pomembno: Sprememba urnika pohoda",
        "Obveščamo vse prijavljene na Planinski pohod Pohorje, da se začetna ura premika z 8:00 na 9:00. Zbiramo se na istem mestu. Za vprašanja pišite na info@mojedrustvo.si.",
        "obvestilo",
        1, 1, 2
    ],
    [
        "Iščemo prostovoljce za turnir",
        "Za organizacijo Nogometnega turnirja 15. junija iščemo 3-4 prostovoljce, ki bi pomagali pri registraciji ekip in vodenju rezultatov. Zainteresirani se javite pri administratorju.",
        "obvestilo",
        1, 0, 2
    ],
    [
        "Fotogalerija: Zimski pohod 2025",
        "Objavili smo fotografije z zimskega pohoda, ki je potekal februarja. Hvala vsem udeležencem za odlično vzdušje! Galerijo si lahko ogledate v članski sekciji.",
        "novica",
        0, 0, 2
    ],
    [
        "Sestanek upravnega odbora",
        "Spoštovani člani upravnega odbora, naslednji sestanek bo v torek, 10. junija ob 18:00 v prostorih društva. Na dnevnem redu: pregled financ, načrtovanje jeseni, razno.",
        "vabilo",
        0, 0, 2
    ],
];

$admin_row2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM uporabnik WHERE vloga = 'admin' LIMIT 1"));
$avtor_id = $admin_row2 ? (int)$admin_row2["id"] : 0;

if ($avtor_id > 0) {
    foreach ($objaveStart as $o) {
        $obstaja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM objava WHERE naslov = '$o[0]'"));
        if (!$obstaja) {
            mysqli_query($conn, "INSERT INTO objava (naslov, vsebina, tip, je_javna, je_pomembna, avtor_id)
                                 VALUES ('$o[0]', '$o[1]', '$o[2]', $o[3], $o[4], $o[5])");
        }
    }
}

mysqli_set_charset($conn, "utf8");
?>