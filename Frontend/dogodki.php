<?php
require_once '../Backend/dogodki_backend.php';
// $jwtToken, $uporabnik, $dogodki, $vrste, $sporocilo, $izbrana_vrsta so ze nastavljeni
$jwtEncoded = htmlspecialchars($jwtToken ?? "");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link href="style.css" rel="stylesheet">
    <title>Dogodki - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<script>
// Preberi JWT iz sessionStorage in daj backendу vedeti kdo je
(function() {
    const jwt = sessionStorage.getItem("jwt");
    if (!jwt) return;
    // Posodobi vse skrite jwt inpute v formah
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("input.jwt-input").forEach(el => el.value = jwt);
    });
})();
</script>

<main class="container py-5">
    <h2 class="mb-4">Dogodki</h2>

    <?php if ($sporocilo): ?>
        <div class="alert alert-info"><?= htmlspecialchars($sporocilo) ?></div>
    <?php endif; ?>

    <div class="mb-4 d-flex gap-2 flex-wrap">
        <?php
        foreach ($vrste as $vrednost => $oznaka):
            $aktiven = $izbrana_vrsta == $vrednost ? "btn-dark" : "btn-outline-secondary";
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
        <div class="col-md-4">
            <div class="card kartica-dogodek h-100">
                <div class="card-header fw-bold fs-5">
                    <?= htmlspecialchars($dogodek["naslov"]) ?>

                    <?php if ($uporabnik && (($uporabnik["vloga"] ?? "") !== "admin")): ?>
                        <div class="float-end ms-2">
                            <form method="POST" action="../Backend/dodajanje_med_priljubljene.php" class="m-0">
                                <input type="hidden" name="jwt" class="jwt-input" value="<?= $jwtEncoded ?>">
                                <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                    <i class="bi bi-heart-fill"></i>
                                </button>   
                            </form>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($dogodek["slika_url"])): ?>
                    <img src="<?= htmlspecialchars($dogodek["slika_url"]) ?>" class="slika-dogodek w-100" alt="Slika dogodka">
                <?php else: ?>
                    <div class="brez-slike"></div>
                <?php endif; ?>

                <div class="card-body">
                    <p class="text-muted mb-1">
                        <small><?= date("d. m. Y H:i", strtotime($dogodek["datum_cas"])) ?></small>
                    </p>
                    <?php if (!empty($dogodek["lokacija"])): ?>
                        <p class="text-muted mb-1"><small><?= htmlspecialchars($dogodek["lokacija"]) ?></small></p>
                    <?php endif; ?>
                    <?php if (!empty($dogodek["opis"])): ?>
                        <p class="card-text mt-2"><?= htmlspecialchars($dogodek["opis"]) ?></p>
                    <?php endif; ?>
                    <div class="mt-2 d-flex gap-1">
                        <span class="badge bg-secondary"><?= htmlspecialchars($dogodek["vrsta"]) ?></span>
                        <?php if ($dogodek["cena"] > 0): ?>
                            <span class="badge bg-info text-dark"><?= number_format($dogodek["cena"], 2) ?> EUR</span>
                        <?php else: ?>
                            <span class="badge bg-success">Brezplacno</span>
                        <?php endif; ?>
                        <?php if ($dogodek["st_mest"] > 0): ?>
                            <span class="badge bg-light text-dark"><?= $dogodek["st_mest"] ?> mest</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="prijava-obmocje hidden">
        <form method="POST">
            <input type="hidden" name="jwt" class="jwt-input">
            <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
            <button type="submit" name="prijava_dogodek" class="btn btn-primary w-100">
                Prijava
            </button>
        </form>

        <form method="POST" action="../Backend/komentar.php" class="mt-2" onsubmit="return preveriKomentar(this)">
            <input type="hidden" name="jwt" class="jwt-input">
            <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
            <textarea name="besedilo" class="form-control" rows="2" placeholder="Napiši komentar..."></textarea>
            <button type="submit" class="btn btn-secondary btn-sm mt-2 w-100">
                Komentiraj
            </button>
        </form>

        <button type="button"
            class="btn btn-outline-secondary btn-sm w-100 mt-2"
            onclick="toggleKomentarji(<?= $dogodek['id'] ?>)">
            Prikaži komentarje
        </button>

        <div id="komentarji<?= $dogodek['id'] ?>" style="display:none;"></div>
    </div>

    <div class="admin-obmocje hidden">
        <a href="uredi_dogodek.php?id=<?= $dogodek["id"] ?>" class="btn btn-outline-secondary w-100 admin-link">
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
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="komentarji.js"></script>
<script>
// Vstavi JWT iz sessionStorage v vse jwt-input polja (za primer fresh load brez GET jwt)
document.addEventListener("DOMContentLoaded", function() {
    const jwt = sessionStorage.getItem("jwt");
    if (jwt) {
        document.querySelectorAll("input.jwt-input").forEach(el => {
            if (!el.value) el.value = jwt;
        });
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = sessionStorage.getItem("jwt");

    if (!token) {
        return;
    }

    let uporabnik;

    try {
        uporabnik = JSON.parse(atob(token.split(".")[1]));
    } catch (e) {
        return;
    }

    document.querySelectorAll(".jwt-input").forEach(input => {
        input.value = token;
    });

    document.querySelectorAll(".login-gumb").forEach(gumb => {
        gumb.classList.add("hidden");
    });

    if (uporabnik.vloga === "admin") {
        document.querySelectorAll(".admin-obmocje").forEach(div => {
            div.classList.remove("hidden");
            document.querySelectorAll(".admin-link").forEach(link => {
            const url = new URL(link.href);
            url.searchParams.set("jwt", token);
            link.href = url.toString();
});
        });
    } else {
        document.querySelectorAll(".prijava-obmocje").forEach(div => {
            div.classList.remove("hidden");
        });
    }
});
</script>

</body>
</html>