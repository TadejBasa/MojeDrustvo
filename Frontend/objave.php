<?php
session_start();
require_once 'config.php';

if (isset($_SESSION["uporabnik_id"])) {
    $sql = "SELECT * FROM objava ORDER BY datum_objave DESC";
} else {
    $sql = "SELECT * FROM objava WHERE je_javna = 1 ORDER BY datum_objave DESC";
}
$rezultat = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com/"></script>
  <title>Objave - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4">Objave</h2>

  <?php if (!isset($_SESSION["uporabnik_id"])): ?>
    <div class="alert alert-info">
      Prijavi se za ogled internih objav. <a href="login.php">Prijava</a>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <?php if (mysqli_num_rows($rezultat) == 0): ?>
      <p class="text-muted">Ni objav.</p>
    <?php endif; ?>

    <?php while ($row = mysqli_fetch_assoc($rezultat)): ?>
      <?php
      $border = "border-secondary";
      $badge  = "bg-secondary";
      if ($row["tip"] == "novica")    { $border = "border-primary";  $badge = "bg-primary"; }
      if ($row["tip"] == "obvestilo") { $border = "border-warning";  $badge = "bg-warning text-dark"; }
      if ($row["tip"] == "zapisnik")  { $border = "border-info";     $badge = "bg-info text-dark"; }
      if ($row["tip"] == "vabilo")    { $border = "border-success";  $badge = "bg-success"; }
      ?>
      <div class="col-md-4">
        <div class="card shadow-sm h-100 border-start border-3 <?= $border ?>">
          <div class="card-body p-4">
            <?php if ($row["je_pomembna"]): ?>
              <span class="badge bg-danger mb-1">Pomembno</span>
            <?php endif; ?>
            <?php if (!$row["je_javna"]): ?>
              <span class="badge bg-dark mb-1">Interno</span>
            <?php endif; ?>
            <span class="badge <?= $badge ?> mb-2"><?= htmlspecialchars($row["tip"]) ?></span>
            <h5><?= htmlspecialchars($row["naslov"]) ?></h5>
            <p><?= htmlspecialchars($row["vsebina"]) ?></p>
            <small class="text-muted"><?= date("d. m. Y", strtotime($row["datum_objave"])) ?></small>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>