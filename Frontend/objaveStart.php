<?php
require_once __DIR__ . '/../Backend/config.php';

$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM uporabnik WHERE vloga = 'admin' LIMIT 1"));
$avtor_id = $admin ? (int)$admin["id"] : 1;

$objave = [
    // naslov, vsebina, tip, je_javna, je_pomembna, datum_objave
    [
        "Vabilo na zaključno druženje sezone",
        "Vabimo vse člane in njihove družine na zaključno druženje sezone — žar, glasba in podelitev priznanj. 30. avgusta ob 17:00 pri FERI.",
        "vabilo", 1, 1, "2026-06-05 10:00:00"
    ],
    [
        "FERI ekipa na regijskem turnirju",
        "Naša ekipa se je uvrstila v finale regijskega turnirja v Celju! Hvala vsem članom za podporo. Finale bo 12. julija.",
        "novica", 1, 1, "2026-06-03 14:30:00"
    ],
    [
        "Vpis v društvo 2026/2027",
        "Vpisna mesta za novo sezono so odprta. Prijavite se do 30. junija na info@feri-sport.si ali osebno v prostorih društva.",
        "obvestilo", 1, 1, "2026-06-01 09:00:00"
    ],
    [
        "Novo: sekcija za badminton",
        "S septembrom 2026 odpiramo novo badminton sekcijo! Treningi bodo potekali dvakrat tedensko v telovadnici. Zanimanje prijavite v tajništvu.",
        "novica", 1, 0, "2026-05-28 11:00:00"
    ],
    [
        "Vabilo na odbojkarski turnir",
        "Poletni odbojkarski turnir v parih vas čaka 5. avgusta v Mestnem parku! Kotizacija 2 EUR na osebo. Prijavite se do 1. avgusta.",
        "vabilo", 1, 0, "2026-05-25 16:00:00"
    ],
    [
        "Sprememba urnika delavnice prve pomoči",
        "Obveščamo člane, da se delavnica prve pomoči zamika na 10. julij ob 14:00. Lokacija ostaja enaka — predavalnica Alfa na FERI.",
        "obvestilo", 1, 1, "2026-05-20 08:30:00"
    ],
    [
        "Interno: sestanek vodstva društva",
        "Obveščamo člane vodstva, da bo redni sestanek v četrtek ob 18:00 v sobi 101. Prisotnost je obvezna.",
        "obvestilo", 0, 1, "2026-05-15 12:00:00"
    ],
    [
        "Vabilo na planinski pohod Pohorje",
        "Pridružite se nam na skupinskem pohodu na Pohorje! Odhod 22. junija ob 8:00 izpred FERI. Prijave zbiramo do 18. junija.",
        "vabilo", 1, 0, "2026-05-10 09:00:00"
    ],
    [
        "Vabilo na nogometni turnir",
        "Vabimo vse ljubitelje malega nogometa na letni turnir FERI! Turnir bo 15. junija na Ljudskem vrtu. Ekipe se prijavijo do 10. junija.",
        "vabilo", 1, 0, "2026-05-05 10:00:00"
    ],
    [
        "Obvestilo o vzdrževanju opreme",
        "V tednu od 1. do 5. julija bomo izvajali pregled in vzdrževanje športne opreme. V tem času posoja opreme ne bo mozna.",
        "obvestilo", 1, 0, "2026-04-28 13:00:00"
    ],
    [
        "Vabilo: skupni ogled tekme NK Maribor",
        "Clane vabimo na skupni ogled tekme NK Maribor v juliju! Srecamo se pred stadionom. Vstopnice si priskrbite sami.",
        "vabilo", 1, 0, "2026-04-20 17:00:00"
    ],
    [
        "Rezultati kosarkarskega vecera",
        "Zahvaljujemo se vsem udeležlencem! Zmagala je ekipa Byte Ballers s 3 zaporednimi zmagami. Cestitke! Naslednji vecer bo julija.",
        "novica", 1, 0, "2026-04-10 20:00:00"
    ],
    [
        "Interno: glasovanje o novem pravilniku",
        "Clani so vabljeni k glasovanju o predlogu novega disciplinskega pravilnika. Gradivo je dostopno v clanski pisarni.",
        "obvestilo", 0, 0, "2026-03-15 10:00:00"
    ],
    [
        "Zahvala sponzorjem sezone 2025/2026",
        "Iskrena zahvala vsem sponzorjem, ki so podprli nase delovanje v pretekli sezoni. Brez vase pomoci nasi dogodki ne bi bili mozni.",
        "novica", 1, 0, "2026-02-20 09:00:00"
    ],
    [
        "Dobrodosli v Sportnem drustvu FERI",
        "Pozdravljamo vse nove in stare clane! Letosnja sezona prinasa polno novih dogodkov, turnirjev in izletov. Skupaj bomo naredili se boljso skupnost.",
        "novica", 1, 1, "2026-01-05 08:00:00"
    ],
];

$stmt = mysqli_prepare($conn,
    "INSERT INTO objava (naslov, vsebina, tip, je_javna, je_pomembna, avtor_id, datum_objave)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$dodanih     = 0;
$preskocenih = 0;

foreach ($objave as $o) {
    [$naslov, $vsebina, $tip, $je_javna, $je_pomembna, $datum_objave] = $o;

    $obstaja = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT id FROM objava WHERE naslov = '" . mysqli_real_escape_string($conn, $naslov) . "' LIMIT 1")
    );

    if ($obstaja) {
        $preskocenih++;
        continue;
    }

    mysqli_stmt_bind_param($stmt, "sssiiss",
        $naslov, $vsebina, $tip, $je_javna, $je_pomembna, $avtor_id, $datum_objave
    );
    mysqli_stmt_execute($stmt);
    $dodanih++;
}

echo "<p>Dodanih: <strong>$dodanih</strong></p>";
echo "<p>Preskocenih (ze obstajajo): <strong>$preskocenih</strong></p>";
echo "<p><a href='../Frontend/objave.php'>Objave</a></p>";