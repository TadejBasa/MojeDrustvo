<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="style.css" rel="stylesheet">
    <title>Priljubljeni dogodki - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="ozadje">
<div class="main">
<main data-aos="fade-up" class="container">
    <h2 class="naslov-dogodki">PRILJUBLJENI DOGODKI</h2>

    <div id="sporocilo-vsebina"></div>

    <div class="row g-4" id="priljubljeni-vsebina">
        <p class="text-muted">Nalaganje...</p>
    </div>
</main>
</div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true, offset: 100 });</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = sessionStorage.getItem("jwt");

    if (!token) {
        window.location.href = "login.php";
        return;
    }

    fetch("../Backend/priljubljeniDogodki_backend.php", {
        headers: { "Authorization": "Bearer " + token }
    })
    .then(res => res.json())
    .then(dogodki => {
        const vsebina = document.getElementById("priljubljeni-vsebina");

        if (!dogodki || dogodki.length === 0) {
            vsebina.innerHTML = '<p class="text-muted">Nimaš še nobenih priljubljenih dogodkov.</p>';
            return;
        }

        vsebina.innerHTML = dogodki.map(d => {
            const prostaMesta = d.st_mest - d.stevilo_prijav;
            const odstotek    = d.st_mest > 0 ? Math.round((d.stevilo_prijav / d.st_mest) * 100) : 100;
            const barva       = odstotek >= 100 ? 'bg-danger' : (odstotek >= 75 ? 'bg-warning' : 'bg-success');
            const datum       = new Date(d.datum_cas).toLocaleString("sl-SI", { day:"2-digit", month:"2-digit", year:"numeric", hour:"2-digit", minute:"2-digit" });

            return `
            <div class="col-md-4">
                <div class="card kartica-dogodek h-100 bg-white">
                    <div class="card-header fw-bold fs-5">
                        ${d.naslov}
                    </div>
                    ${d.slika_url
                        ? `<img src="${d.slika_url}" class="slika-dogodek w-100" alt="Slika dogodka">`
                        : `<div class="brez-slike"></div>`}
                    <div class="card-body">
                        <p class="text-muted mb-1"><small>${datum}</small></p>
                        ${d.lokacija ? `<p class="text-muted mb-1"><small>${d.lokacija}</small></p>` : ""}
                        ${d.opis     ? `<p class="card-text mt-2">${d.opis}</p>` : ""}
                        <div class="mt-2 d-flex gap-1">
                            <span class="badge bg-secondary">${d.vrsta}</span>
                            ${d.cena > 0
                                ? `<span class="badge bg-info text-dark">${parseFloat(d.cena).toFixed(2)} EUR</span>`
                                : `<span class="badge bg-success">Brezplačno</span>`}
                            ${prostaMesta > 0
                                ? `<span class="badge bg-success">Prosta mesta: ${prostaMesta}</span>`
                                : `<span class="badge bg-danger">Zasedeno</span>`}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="zasedenost-vrstica mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted fw-semibold">
                                    <i class="bi bi-people-fill me-1"></i>
                                    Zasedenost: ${d.stevilo_prijav} / ${d.st_mest} mest
                                </small>
                                <small class="text-muted">${odstotek}%</small>
                            </div>
                            <div class="progress" style="height:6px; border-radius:4px;">
                                <div class="progress-bar ${barva}" role="progressbar" style="width:${Math.min(odstotek,100)}%"></div>
                            </div>
                        </div>
                        <a href="dogodki.php" class="btn btn-outline-secondary btn-sm w-100">
                            Nazaj na dogodke
                        </a>
                    </div>
                </div>
            </div>`;
        }).join("");
    })
    .catch(() => {
        document.getElementById("priljubljeni-vsebina").innerHTML = '<p class="text-danger">Napaka pri nalaganju.</p>';
    });
});
</script>

</body>
</html>