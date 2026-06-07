<?php
require_once '../Backend/uredi_objavo_backend.php';
// $jwtToken, $o, $napaka, $uspeh so ze nastavljeni
$jwtEncoded = htmlspecialchars($jwtToken ?? "");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Uredi objavo - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
  <h2 class="mb-4">Uredi objavo</h2>

  <?php if ($napaka): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($napaka) ?></div>
  <?php endif; ?>
  <?php if ($uspeh): ?>
    <div class="alert alert-success"><?= htmlspecialchars($uspeh) ?></div>
  <?php endif; ?>

  <div class="card shadow p-4">
    <form method="POST">
      <input type="hidden" name="jwt" id="jwtInput" value="<?= $jwtEncoded ?>">
      <div class="row g-3">

        <div class="col-md-8">
          <label class="form-label">Naslov *</label>
          <input type="text" name="naslov" class="form-control" required
                 value="<?= htmlspecialchars($o["naslov"]) ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label">Tip</label>
          <select name="tip" class="form-select">
            <?php foreach (["novica", "obvestilo", "vabilo"] as $t): ?>
              <option value="<?= $t ?>" <?= $o["tip"] == $t ? "selected" : "" ?>><?= ucfirst($t) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Vsebina</label>
          <textarea name="vsebina" class="form-control" rows="6"><?= htmlspecialchars($o["vsebina"]) ?></textarea>
        </div>

        <div class="col-12">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="je_javna" id="je_javna"
                   <?= $o["je_javna"] ? "checked" : "" ?>>
            <label class="form-check-label" for="je_javna">Javna objava</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="je_pomembna" id="je_pomembna"
                   <?= $o["je_pomembna"] ? "checked" : "" ?>>
            <label class="form-check-label" for="je_pomembna">Pomembna</label>
          </div>
        </div>

        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-success">Shrani spremembe</button>
          <a href="admin.php?jwt=<?= urlencode($jwtToken) ?>" class="btn btn-outline-secondary">Prekliči</a>
        </div>

      </div>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const jwt = sessionStorage.getItem("jwt");
    if (jwt) {
        const inp = document.getElementById("jwtInput");
        if (inp && !inp.value) inp.value = jwt;
    }
});
</script>
</body>
</html>