<?php
session_start();
require_once '../Backend/config.php';

$izbrani_tip = $_GET["tip"] ?? "vse";

$pogoj = isset($_SESSION["uporabnik_id"]) ? "WHERE 1=1" : "WHERE je_javna = 1";

if ($izbrani_tip != "vse") {
    $tip_varen = mysqli_real_escape_string($conn, $izbrani_tip);
    $pogoj .= " AND tip = '$tip_varen'";
}

$objave = mysqli_query($conn, "SELECT * FROM objava $pogoj ORDER BY datum_objave DESC");
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
        .kartica-zapisnik  { border-left: 4px solid #f59e0b; }
        .kartica-vabilo    { border-left: 4px solid #22c55e; }
    </style>

</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
    <h2 class="mb-4">Objave</h2>

    <?php if (!isset($_SESSION["uporabnik_id"])): ?>
        <div class="alert alert-info">
            <a href="login.php">Prijavi se</a> za ogled internih objav.
        </div>
    <?php endif; ?>

    <div class="mb-4 d-flex gap-2 flex-wrap">
        <?php
        $tipi = ["vse" => "Vse", "novica" => "Novice", "obvestilo" => "Obvestila", "zapisnik" => "Zapisniki", "vabilo" => "Vabila"];
        foreach ($tipi as $vrednost => $oznaka):
            $aktiven = $izbrani_tip == $vrednost ? "btn-dark" : "btn-outline-secondary";
        ?>
            <a href="objave.php?tip=<?= $vrednost ?>" class="btn btn-sm <?= $aktiven ?>">
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
                "zapisnik"  => "kartica-zapisnik",
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
                        <?php if (!$objava["je_javna"]): ?>
                            <span class="badge bg-dark">Interno</span>
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
</body>
</html>