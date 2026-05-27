<?php
require_once '../Backend/dogodki_backend.php';
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
    <title>Dogodki - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
    <h2 class="mb-4">Dogodki</h2>

    <?php if ($sporocilo): ?>
        <div class="alert alert-info"><?= htmlspecialchars($sporocilo) ?></div>
    <?php endif; ?>

    <?php if (!$uporabnik): ?>
        <div class="alert alert-warning">
            <a href="login.php">Prijavi se</a> za prijavo na dogodke.
        </div>
    <?php endif; ?>

    <div class="mb-4 d-flex gap-2 flex-wrap">
        <?php
        foreach ($vrste as $vrednost => $oznaka):
            $aktiven = $izbrana_vrsta == $vrednost ? "btn-dark" : "btn-outline-secondary";
        ?>
            <a href="dogodki.php?vrsta=<?= $vrednost ?>" class="btn btn-sm <?= $aktiven ?>">
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
                        <p class="text-muted mb-1">
                            <small><?= htmlspecialchars($dogodek["lokacija"]) ?></small>
                        </p>
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
                    <?php if ($uporabnik && $uporabnik["vloga"] != "admin"): ?>
                        <form method="POST">
                            <input type="hidden" name="dogodek_id" value="<?= $dogodek["id"] ?>">
                            <button type="submit" name="prijava_dogodek" class="btn btn-primary w-100">Prijava</button>
                        </form>
                    <?php elseif ($uporabnik && $uporabnik["vloga"] == "admin"): ?>
                        <a href="admin.php" class="btn btn-outline-secondary w-100">Upravljaj</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-primary w-100">Prijavi se za prijavo</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>