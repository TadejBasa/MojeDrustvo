<?php
require_once '../Backend/dogodki_backend.php';
$jwtEncoded = htmlspecialchars($jwtToken ?? "");
?>
<!DOCTYPE html>
<html lang="sl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="style.css" rel="stylesheet">
    <title>Dogodki - Moje Društvo</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <script>
        (function () {
            const jwt = sessionStorage.getItem("jwt");
            if (!jwt) return;
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll("input.jwt-input").forEach(el => el.value = jwt);
            });
        })();
    </script>
    <div class="ozadje">
        <div class="main">
            <main data-aos="fade-up" class="container">
                <h2 class="naslov-dogodki">DOGODKI</h2>

                <?php if ($sporocilo): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($sporocilo) ?></div>
                <?php endif; ?>

                <?php if (isset($_GET["priljubljeni"])): ?>
                    <?php if ($_GET["priljubljeni"] === "dodano"): ?>
                        <div class="alert alert-info">Dodano med priljubljene dogodke!</div>
                    <?php elseif ($_GET["priljubljeni"] === "odstranjeno"): ?>
                        <div class="alert alert-info">Odstranjeno iz priljubljenih dogodkov.</div>
                    <?php endif; ?>
                <?php endif; ?>
                <input type="text" id="iskanje-dogodkov" class="form-control mb-3" placeholder=" Išči dogodke"
                    style="border-radius: 8px; border: 1px solid #dee2e6; padding: 10px 16px; background: white;">

                <div class="mb-4 d-flex gap-2 flex-wrap">
                    <?php
                    foreach ($vrste as $vrednost => $oznaka):
                        $aktiven = $izbrana_vrsta == $vrednost ? "btn-primary" : "btn-outline-secondary";
                        $jwtParam = $jwtToken ? "&jwt=" . urlencode($jwtToken) : "";
                        ?>
                        <a href="dogodki.php?vrsta=<?= $vrednost ?><?= $jwtParam ?>" class="btn btn-sm <?= $aktiven ?>">
                            <?= $oznaka ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="row g-4">
                    <?php if (mysqli_num_rows($dogodki) == 0): ?>
                        <p class="text-muted">Ni dogodkov.</p>
                    <?php endif; ?>

                    <?php while ($dogodek = mysqli_fetch_assoc($dogodki)): ?>
                        <?php
                        $prosta_mesta = $dogodek["st_mest"] - $dogodek["stevilo_prijav"];
                        ?>
                        <div class="col-md-4 flex-wrap">
                            <div class="card kartica-dogodek h-100 bg-white ">
                                <div class="card-header fw-bold fs-5">
                                    <?= htmlspecialchars($dogodek["naslov"]) ?>

                                    <div class="float-end ms-2 priljubljeni-gumb hidden">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger rounded-circle priljubljen-btn"
                                            data-dogodek-id="<?= $dogodek['id'] ?>" title="Dodaj med priljubljene">
                                            <i class="bi bi-heart-fill"></i>
                                        </button>
                                    </div>
                                </div>

                                <?php if (!empty($dogodek["slika_url"])): ?>
                                    <img src="<?= htmlspecialchars($dogodek["slika_url"]) ?>" class="slika-dogodek w-100"
                                        alt="Slika dogodka">
                                <?php else: ?>
                                    <div class="brez-slike"></div>
                                <?php endif; ?>

                                <div class="card-body">
                                    <p class="text-muted mb-1">
                                        <small><?= date("d. m. Y H:i", strtotime($dogodek["datum_cas"])) ?></small>
                                    </p>
                                    <?php if (!empty($dogodek["lokacija"])): ?>
                                        <p class="text-muted mb-1"><small><?= htmlspecialchars($dogodek["lokacija"]) ?></small>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($dogodek["opis"])): ?>
                                        <p class="card-text mt-2"><?= htmlspecialchars($dogodek["opis"]) ?></p>
                                    <?php endif; ?>
                                    <div class="mt-2 d-flex gap-1">
                                        <span class="badge bg-secondary"><?= htmlspecialchars($dogodek["vrsta"]) ?></span>
                                        <?php if ($dogodek["cena"] > 0): ?>
                                            <span class="badge bg-info text-dark"><?= number_format($dogodek["cena"], 2) ?>
                                                EUR</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Brezplacno</span>
                                        <?php endif; ?>
                                        <?php if ($prosta_mesta > 0): ?>
                                            <span class="badge bg-success">
                                                Prosta mesta: <?= $prosta_mesta ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                Dogodek zaseden
                                            </span>
                                        <?php endif; ?>
                                        <span class="badge bg-pink text-white" style="background-color:#e91e63;">
                                            <i class="bi bi-heart-fill me-1"></i><?= (int)$dogodek["stevilo_priljubljenih"] ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-footer">
    <div class="zasedenost-vrstica mb-2">
        <?php
        $stevilo_prijav = (int) $dogodek["stevilo_prijav"];
        $skupaj_mest = (int) $dogodek["st_mest"];
        $odstotek = $skupaj_mest > 0 ? round(($stevilo_prijav / $skupaj_mest) * 100) : 100;
        $barva_prog = $odstotek >= 100 ? 'bg-danger' : ($odstotek >= 75 ? 'bg-warning' : 'bg-success');
        ?>
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="text-muted fw-semibold">
                <i class="bi bi-people-fill me-1"></i>
                Zasedenost: <?= $stevilo_prijav ?> / <?= $skupaj_mest ?> mest
            </small>
            <small class="text-muted"><?= $odstotek ?>%</small>
        </div>
        <div class="progress" style="height: 6px; border-radius: 4px;">
            <div class="progress-bar <?= $barva_prog ?>" role="progressbar"
                style="width: <?= min($odstotek, 100) ?>%"
                aria-valuenow="<?= $stevilo_prijav ?>" aria-valuemin="0"
                aria-valuemax="<?= $skupaj_mest ?>">
            </div>
        </div>
    </div>

    <div class="prijava-obmocje hidden">
        <form method="POST">
            <input type="hidden" name="jwt" class="jwt-input">
            <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
            <?php if ($prosta_mesta > 0): ?>
                <button type="submit" name="prijava_dogodek" class="btn btn-primary w-100">
                    Prijava
                </button>
            <?php else: ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-0 py-2 px-3" role="alert">
                    <i class="bi bi-x-circle-fill fs-5"></i>
                    <span class="fw-semibold">Dogodek je zaseden</span>
                </div>
            <?php endif; ?>
        </form>

        <form method="POST" action="../Backend/komentar.php" class="mt-2"
            onsubmit="return preveriKomentar(this)">
            <input type="hidden" name="jwt" class="jwt-input">
            <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
            <textarea name="besedilo" class="form-control" rows="2"
                placeholder="Napiši komentar..."></textarea>
            <button type="submit" class="btn btn-secondary btn-sm mt-2 w-100">
                Komentiraj
            </button>
        </form>
    </div>

    <?php
    $preview = $komentarji_preview[$dogodek['id']] ?? [];
    $ze_prikazano = count($preview);
    ?>

    <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2"
        id="gumb-komentarji<?= $dogodek['id'] ?>"
        data-razsirjen="<?= $ze_prikazano > 0 ? '1' : '0' ?>"
        onclick="toggleKomentarji(<?= $dogodek['id'] ?>)">
        <?= $ze_prikazano > 0 ? 'Vsi komentarji' : 'Prikaži komentarje' ?>
    </button>

    <div id="komentarji<?= $dogodek['id'] ?>"
     style="display: <?= $ze_prikazano > 0 ? 'block' : 'none' ?>; height: auto; overflow: visible;"
     data-nalozeno="0">
        <?php foreach ($preview as $k): ?>
            <?php
            $slika = !empty($k['profilna_slika'])
                ? htmlspecialchars($k['profilna_slika'])
                : '../Frontend/img/privzeta_slika.png';
            ?>
            <div class="d-flex align-items-start gap-2 border rounded p-2 mt-2 small komentar-blok">
                <img src="<?= $slika ?>"
                     alt="Profil"
                     style="width:32px; height:32px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                <div>
                    <span class="fw-semibold text-dark"><?= htmlspecialchars($k['username']) ?></span>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($k['besedilo']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="admin-obmocje hidden">
        <a href="uredi_dogodek.php?id=<?= $dogodek["id"] ?>"
            class="btn btn-outline-secondary w-100 admin-link">
            Upravljaj
        </a>
    </div>

    <a href="login.php" class="btn btn-outline-primary w-100 login-gumb">
        Prijavi se za prijavo
    </a>

</div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
        </div>
        </main>
    </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="komentarji.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        AOS.init({ duration: 800, once: true, offset: 100 });

        const token = sessionStorage.getItem("jwt");

        const iskanje = document.getElementById("iskanje-dogodkov");
        iskanje.addEventListener("input", () => {
            const query = iskanje.value.toLowerCase().trim();
            document.querySelectorAll(".col-md-4").forEach(kartica => {
                const naslov = kartica.querySelector(".card-header").textContent.toLowerCase();
                kartica.style.display = naslov.includes(query) ? "" : "none";
            });
        });

        if (!token) return;

        document.querySelectorAll("input.jwt-input").forEach(el => {
            if (!el.value) el.value = token;
        });

        let uporabnik;
        try {
            uporabnik = JSON.parse(atob(token.split(".")[1]));
        } catch (e) {
            return;
        }

        document.querySelectorAll(".login-gumb").forEach(gumb => {
            gumb.classList.add("hidden");
        });

        if (uporabnik.vloga === "admin") {
            document.querySelectorAll(".admin-obmocje").forEach(div => {
                div.classList.remove("hidden");
            });
            document.querySelectorAll(".admin-link").forEach(link => {
                const url = new URL(link.href);
                url.searchParams.set("jwt", token);
                link.href = url.toString();
            });
        } else {
            document.querySelectorAll(".prijava-obmocje").forEach(div => {
                div.classList.remove("hidden");
            });
            document.querySelectorAll(".priljubljeni-gumb").forEach(div => {
                div.classList.remove("hidden");
            });
        }

        fetch('../Backend/get_priljubljeni.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'jwt=' + encodeURIComponent(token)
        })
        .then(r => r.json())
        .then(priljubljeni => {
            document.querySelectorAll('.priljubljen-btn').forEach(btn => {
                const id = parseInt(btn.dataset.dogodekId);

                if (priljubljeni.includes(id)) {
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-danger');
                    btn.title = 'Odstrani iz priljubljenih';
                }

                btn.addEventListener('click', () => {
                    const dogodekId = btn.dataset.dogodekId;
                    const body = 'jwt=' + encodeURIComponent(token) + '&dogodek_id=' + dogodekId;

                    btn.disabled = true;

                    fetch('../Backend/dodajanje_med_priljubljene.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: body
                    })
                    .then(r => r.json())
                    .then(odgovor => {
                        if (odgovor.status === 'dodano') {
                            btn.classList.remove('btn-outline-danger');
                            btn.classList.add('btn-danger');
                            btn.title = 'Odstrani iz priljubljenih';
                        } else if (odgovor.status === 'odstranjeno') {
                            btn.classList.remove('btn-danger');
                            btn.classList.add('btn-outline-danger');
                            btn.title = 'Dodaj med priljubljene';
                        } else {
                            alert('Napaka: ' + (odgovor.sporocilo ?? 'Neznan odgovor'));
                        }
                    })
                    .catch(() => alert('Napaka pri shranjevanju.'))
                    .finally(() => { btn.disabled = false; });
                });
            });
        })
        .catch(e => console.error('Napaka pri nalaganju priljubljenih:', e));

    });
</script>

</body>

</html>