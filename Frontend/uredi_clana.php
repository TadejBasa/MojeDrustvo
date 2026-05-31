<?php
require_once '../Backend/uredi_clana_backend.php';
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
    <title>Uredi člana - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
  <h2 class="mb-4">Uredi člana</h2>

  <?php if ($napaka): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($napaka) ?></div>
  <?php endif; ?>
  <?php if ($uspeh): ?>
    <div class="alert alert-success"><?= htmlspecialchars($uspeh) ?></div>
  <?php endif; ?>

  <div class="card shadow p-4">
    <form method="POST">
      <div class="row g-3">

        <div class="col-md-4">
          <label class="form-label">Ime *</label>
          <input type="text" name="ime" class="form-control" required
                 value="<?= htmlspecialchars($u["ime"]) ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label">Priimek *</label>
          <input type="text" name="priimek" class="form-control" required
                 value="<?= htmlspecialchars($u["priimek"]) ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label">Username *</label>
          <input type="text" name="username" class="form-control" required
                 value="<?= htmlspecialchars($u["username"]) ?>">
        </div>

        <div class="col-md-5">
          <label class="form-label">E-pošta *</label>
          <input type="email" name="email" class="form-control" required
                 value="<?= htmlspecialchars($u["email"]) ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Vloga</label>
          <select name="vloga" class="form-select">
            <?php foreach (["neclan", "clan", "admin"] as $v): ?>
              <option value="<?= $v ?>" <?= $u["vloga"] == $v ? "selected" : "" ?>><?= ucfirst($v) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4">
          <label class="form-label">Datum rojstva</label>
          <input type="date" name="datum_rojstva" class="form-control"
                 value="<?= htmlspecialchars($u["datum_rojstva"] ?? "") ?>">
        </div>

        <div class="col-md-5">
          <label class="form-label">Novo geslo <small class="text-muted">(pustite prazno, če ne želite spremeniti)</small></label>
          <input type="password" name="novo_geslo" class="form-control" minlength="6">
        </div>

        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-success">Shrani spremembe</button>
          <a href="admin.php" class="btn btn-outline-secondary">Prekliči</a>
        </div>

      </div>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>