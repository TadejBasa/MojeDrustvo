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

    mysqli_stmt_bind_param($stmt, "ssssdiisi",
        $naslov, $opis, $lokacija, $datum_cas,
        $cena, $st_mest, $vrsta, $slika_url, $kreator_id
    );
    mysqli_stmt_execute($stmt);
    $dodanih++;
}

echo "<p>Dodanih: <strong>$dodanih</strong></p>";
echo "<p><a href='../Frontend/dogodki.php'>Dogodki</a></p>";