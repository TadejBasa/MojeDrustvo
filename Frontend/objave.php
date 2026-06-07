<?php
require_once '../Backend/objave_backend.php';
$jwtEncoded = htmlspecialchars($jwtToken ?? "");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="style.css" rel="stylesheet">
    <title>Objave - Moje Društvo</title>
<body>

<?php include 'header.php'; ?>

<div class = "ozadje">
<div class = "main h-full">
<main data-aos="fade-up" class="container py-5">
    <h2 class="naslov-objave">OBJAVE</h2>

    <div id="opozorilo-prijava" class="alert alert-info" style="display:none;">
        <a href="login.php">Prijavi se</a> za ogled privatnih objav.
    </div>
    <input type="text" id="iskanje-objav" class="form-control mb-3" placeholder=" Išči objave"
                    style="border-radius: 8px; border: 1px solid #dee2e6; padding: 10px 16px; background: white;">

    <div class="mb-4 d-flex gap-2 flex-wrap">
        <?php foreach ($tipi as $vrednost => $oznaka):
            $aktiven = $izbrani_tip == $vrednost ? "btn-primary" : "btn-outline-secondary";
        ?>
            <a href="objave.php?tip=<?= $vrednost ?>"
               class="btn btn-sm bg-white text-black <?= $aktiven ?> filter-link">
                <?= $oznaka ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($objave) == 0): ?>
            <p class="text-muted">Ni objav.</p>
        <?php endif; ?>

        <?php while ($objava = mysqli_fetch_assoc($objave)):
            $slog = match($objava["tip"]) {
                "novica"    => "kartica-novica",
                "obvestilo" => "kartica-obvestilo",
                "vabilo"    => "kartica-vabilo",
                default     => ""
            };
        ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 bg-white <?= $slog ?>">
                <div class="card-body p-4">
                    <div class="mb-2 d-flex gap-1 flex-wrap">
                        <?php if ($objava["je_pomembna"]): ?>
                            <span class="badge bg-danger">Pomembno</span>
                        <?php endif; ?>
                        <span class="badge bg-secondary"><?= htmlspecialchars($objava["tip"]) ?></span>
                    </div>
                    <h5 class="card-title"><?= htmlspecialchars($objava["naslov"]) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($objava["vsebina"]) ?></p>
                    <small class="text-muted"><?= date("d. m. Y", strtotime($objava["datum_objave"])) ?></small>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</main>
</div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const urlJwt = new URLSearchParams(window.location.search).get("jwt");
    if (urlJwt) {
        sessionStorage.setItem("jwt", urlJwt);
    }

    const jwt = sessionStorage.getItem("jwt");

    if (!jwt) {
        document.getElementById("opozorilo-prijava").style.display = "block";
        return;
    }

    document.querySelectorAll(".filter-link").forEach(link => {
        const url = new URL(link.href);
        url.searchParams.set("jwt", jwt);
        link.href = url.toString();
    });

    if (!urlJwt) {
        const url = new URL(window.location.href);
        url.searchParams.set("jwt", jwt);
        window.location.replace(url.toString());
    }
    const iskanje = document.getElementById("iskanje-objav");
    iskanje.addEventListener("input", () => {
        const query = iskanje.value.toLowerCase().trim();
        document.querySelectorAll(".col-md-4").forEach(kartica => {
            const naslov = kartica.querySelector(".card-title")?.textContent.toLowerCase() ?? "";
            const vsebina = kartica.querySelector(".card-text")?.textContent.toLowerCase() ?? "";
            kartica.style.display = (naslov.includes(query) || vsebina.includes(query)) ? "" : "none";
        });
    });
});
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>