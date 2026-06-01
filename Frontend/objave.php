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
    <link href="style.css" rel="stylesheet">
    <title>Objave - Moje Društvo</title>
    <style>
        .kartica-novica    { border-left: 4px solid #3b82f6; }
        .kartica-obvestilo { border-left: 4px solid #ef4444; }
        .kartica-vabilo    { border-left: 4px solid #22c55e; }
        .privatna-znacka   { display: none; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
    <h2 class="mb-4">Objave</h2>

    <div id="opozorilo-prijava" class="alert alert-info" style="display:none;">
        <a href="login.php">Prijavi se</a> za ogled privatnih objav.
    </div>

    <div class="mb-4 d-flex gap-2 flex-wrap">
        <?php foreach ($tipi as $vrednost => $oznaka):
            $aktiven = $izbrani_tip == $vrednost ? "btn-dark" : "btn-outline-secondary";
        ?>
            <a href="objave.php?tip=<?= $vrednost ?>"
               class="btn btn-sm <?= $aktiven ?> filter-link">
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
            <div class="card shadow-sm h-100 <?= $slog ?>">
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

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // 1. Shrani JWT če pride prek GET parametra
    const urlJwt = new URLSearchParams(window.location.search).get("jwt");
    if (urlJwt) {
        sessionStorage.setItem("jwt", urlJwt);
    }

    const jwt = sessionStorage.getItem("jwt");

    if (!jwt) {
        // Ni prijavljen — pokaži opozorilo
        document.getElementById("opozorilo-prijava").style.display = "block";
        return;
    }

    // 2. Dodaj JWT vsem filter linkom
    document.querySelectorAll(".filter-link").forEach(link => {
        const url = new URL(link.href);
        url.searchParams.set("jwt", jwt);
        link.href = url.toString();
    });

    // 3. Če stran nima JWT v GET-u, preusmeri z JWT da backend dobi podatke
    if (!urlJwt) {
        const url = new URL(window.location.href);
        url.searchParams.set("jwt", jwt);
        window.location.replace(url.toString());
    }
});
</script>
</body>
</html>