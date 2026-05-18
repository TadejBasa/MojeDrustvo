<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET["id"];

$sql  = "SELECT * FROM dogodek WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$d) {
    header("Location: admin.php");
    exit();
}

$napaka = "";
$uspeh  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov   = trim($_POST["naslov"]);
    $opis     = trim($_POST["opis"]);
    $lokacija = trim($_POST["lokacija"]);
    $datum    = $_POST["datum_cas"];
    $cena     = (float)$_POST["cena"];
    $mesta    = (int)$_POST["st_mest"];
    $vrsta    = $_POST["vrsta"];
    $javen    = isset($_POST["je_javen"]) ? 1 : 0;

    if (empty($naslov) || empty($datum)) {
        $napaka = "Naslov in datum sta obvezna.";
    } else {
        $sql  = "UPDATE dogodek SET naslov=?, opis=?, lokacija=?, datum_cas=?, cena=?, st_mest=?, vrsta=?, je_javen=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssdisii", $naslov, $opis, $lokacija, $datum, $cena, $mesta, $vrsta, $javen, $id);

        if (mysqli_stmt_execute($stmt)) {
            $uspeh = "Dogodek uspešno posodobljen!";
            $d["naslov"]   = $naslov;
            $d["opis"]     = $opis;
            $d["lokacija"] = $lokacija;
            $d["datum_cas"]= $datum;
            $d["cena"]     = $cena;
            $d["st_mest"]  = $mesta;
            $d["vrsta"]    = $vrsta;
            $d["je_javen"] = $javen;
        } else {
            $napaka = "Napaka pri shranjevanju.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Uredi dogodek - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container py-5">
  <h2 class="mb-4">Uredi dogodek</h2>

  <?php if ($napaka): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($napaka) ?></div>
  <?php endif; ?>
  <?php if ($uspeh): ?>
    <div class="alert alert-success"><?= htmlspecialchars($uspeh) ?></div>
  <?php endif; ?>

  <div class="card shadow p-4">
    <form method="POST">
      <div class="row g-3">

        <div class="col-md-6">
          <label class="form-label">Naslov *</label>
          <input type="text" name="naslov" class="form-control" required
                 value="<?= htmlspecialchars($d["naslov"]) ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Datum in ura *</label>
          <input type="datetime-local" name="datum_cas" class="form-control" required
                 value="<?= date("Y-m-d\TH:i", strtotime($d["datum_cas"])) ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Lokacija</label>
          <input type="text" name="lokacija" class="form-control"
                 value="<?= htmlspecialchars($d["lokacija"]) ?>">
        </div>

        <div class="col-md-8">
          <label class="form-label">Opis</label>
          <textarea name="opis" class="form-control" rows="3"><?= htmlspecialchars($d["opis"]) ?></textarea>
        </div>

        <div class="col-md-2">
          <label class="form-label">Cena (€)</label>
          <input type="number" name="cena" class="form-control" min="0" step="0.01"
                 value="<?= $d["cena"] ?>">
        </div>

        <div class="col-md-2">
          <label class="form-label">Št. mest</label>
          <input type="number" name="st_mest" class="form-control" min="0"
                 value="<?= $d["st_mest"] ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Vrsta</label>
          <select name="vrsta" class="form-select">
            <?php foreach (["pohod","delavnica","izlet","akcija","drugo"] as $v): ?>
              <option value="<?= $v ?>" <?= $d["vrsta"] == $v ? "selected" : "" ?>><?= ucfirst($v) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="je_javen" id="javen"
                   <?= $d["je_javen"] ? "checked" : "" ?>>
            <label class="form-check-label" for="javen">Javen dogodek</label>
          </div>
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