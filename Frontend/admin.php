<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["vloga"]) || $_SESSION["vloga"] != "admin") {
    header("Location: index.php");
    exit();
}

if (isset($_GET["brisi_dogodek"])) {
    $did = (int)$_GET["brisi_dogodek"];
    mysqli_query($conn, "DELETE FROM prijava WHERE dogodek_id = $did");
    mysqli_query($conn, "DELETE FROM dogodek WHERE id = $did");
    header("Location: admin.php");
    exit();
}

if (isset($_GET["brisi_objavo"])) {
    $oid = (int)$_GET["brisi_objavo"];
    mysqli_query($conn, "DELETE FROM objava WHERE id = $oid");
    header("Location: admin.php");
    exit();
}

if (isset($_GET["potrdi"])) {
    $pid = (int)$_GET["potrdi"];
    mysqli_query($conn, "UPDATE prijava SET status = 'potrjena' WHERE id = $pid");
    header("Location: admin.php#prijave");
    exit();
}
if (isset($_GET["zavrni"])) {
    $pid = (int)$_GET["zavrni"];
    mysqli_query($conn, "UPDATE prijava SET status = 'zavrnjena' WHERE id = $pid");
    header("Location: admin.php#prijave");
    exit();
}

$napaka_d = "";
if (isset($_POST["dodaj_dogodek"])) {
    $naslov   = trim($_POST["naslov"]);
    $opis     = trim($_POST["opis"]);
    $lokacija = trim($_POST["lokacija"]);
    $datum    = $_POST["datum_cas"];
    $cena     = (float)$_POST["cena"];
    $mesta    = (int)$_POST["st_mest"];
    $vrsta    = $_POST["vrsta"];
    $javen    = isset($_POST["je_javen"]) ? 1 : 0;
    $kreator  = $_SESSION["uporabnik_id"];

    $sql  = "INSERT INTO dogodek (naslov, opis, lokacija, datum_cas, cena, st_mest, vrsta, je_javen, kreator_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssdisii", $naslov, $opis, $lokacija, $datum, $cena, $mesta, $vrsta, $javen, $kreator);
    mysqli_stmt_execute($stmt);
    header("Location: admin.php#dogodki");
    exit();
}

if (isset($_POST["dodaj_objavo"])) {
    $naslov   = trim($_POST["naslov_o"]);
    $vsebina  = trim($_POST["vsebina"]);
    $tip      = $_POST["tip"];
    $javna    = isset($_POST["je_javna"]) ? 1 : 0;
    $pomembna = isset($_POST["je_pomembna"]) ? 1 : 0;
    $avtor    = $_SESSION["uporabnik_id"];

    $sql  = "INSERT INTO objava (naslov, vsebina, tip, je_javna, je_pomembna, avtor_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssiii", $naslov, $vsebina, $tip, $javna, $pomembna, $avtor);
    mysqli_stmt_execute($stmt);
    header("Location: admin.php#objave");
    exit();
}

$dogodki  = mysqli_query($conn, "SELECT * FROM dogodek ORDER BY datum_cas DESC");
$objave   = mysqli_query($conn, "SELECT * FROM objava ORDER BY datum_objave DESC");
$clani    = mysqli_query($conn, "SELECT * FROM uporabnik ORDER BY datum_reg DESC");
$prijave  = mysqli_query($conn, "SELECT p.*, u.ime, u.priimek, d.naslov as d_naslov
                                  FROM prijava p
                                  JOIN uporabnik u ON p.uporabnik_id = u.id
                                  JOIN dogodek d ON p.dogodek_id = d.id
                                  WHERE p.status = 'cakanje'
                                  ORDER BY p.datum_prijave DESC");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Admin - Moje Društvo</title>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Moje Društvo</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Domov</a></li>
          <li class="nav-item"><a class="nav-link active" href="admin.php">Admin panel</a></li>
          <li class="nav-item"><a class="nav-link" href="odjava.php">Odjava</a></li>
        </ul>
        <span class="navbar-text text-warning">Admin: <?= htmlspecialchars($_SESSION["ime"]) ?></span>
      </div>
    </div>
  </nav>
</header>

<main class="container py-4">
  <h2 class="mb-4">Admin panel</h2>

  <ul class="nav nav-tabs mb-4" id="adminTabs">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#dogodki">Dogodki</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prijave">Prijave</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#objave">Objave</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#clani">Člani</a></li>
  </ul>

  <div class="tab-content">

    <div class="tab-pane fade show active " id="dogodki">
      <h4 class = "mb-4">Dodaj dogodek</h4>
      <form method="POST" class="row g-3 mb-4 p-3 border rounded bg-light">
        <div class="col-md-6">
          <input type="text" name="naslov" class="form-control" placeholder="Naslov *" required>
        </div>
        <div class="col-md-3">
          <input type="datetime-local" name="datum_cas" class="form-control" required>
        </div>
        <div class="col-md-3">
          <input type="text" name="lokacija" class="form-control" placeholder="Lokacija">
        </div>
        <div class="col-md-6">
          <textarea name="opis" class="form-control" placeholder="Opis" rows="2"></textarea>
        </div>
        <div class="col-md-2">
          <input type="number" name="cena" class="form-control" placeholder="Cena" min="0" step="0.01">
        </div>
        <div class="col-md-2">
          <input type="number" name="st_mest" class="form-control" placeholder="Stevilo mest" min="0">
        </div>
        <div class="col-md-2">
          <select name="vrsta" class="form-select">
            <option value="pohod">Pohod</option>
            <option value="delavnica">Delavnica</option>
            <option value="izlet">Izlet</option>
            <option value="akcija">Akcija</option>
            <option value="drugo">Drugo</option>
          </select>
        </div>
        <div class="col-md-12">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="je_javen" id="javen" checked>
            <label class="form-check-label" for="javen">Javen dogodek</label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" name="dodaj_dogodek" class="btn btn-success">Dodaj dogodek</button>
        </div>
      </form>

      <h4>Vsi dogodki</h4>
      <table class="table table-striped">
        <thead><tr><th>Naslov</th><th>Datum</th><th>Lokacija</th><th>Javni</th><th>Akcije</th></tr></thead>
        <tbody>
          <?php while ($d = mysqli_fetch_assoc($dogodki)): ?>
          <tr>
            <td><?= htmlspecialchars($d["naslov"]) ?></td>
            <td><?= date("d. m. Y H:i", strtotime($d["datum_cas"])) ?></td>
            <td><?= htmlspecialchars($d["lokacija"]) ?></td>
            <td><?= $d["je_javen"] ? "✅" : "🔒" ?></td>
            <td>
              <a href="uredi_dogodek.php?id=<?= $d["id"] ?>" class="btn btn-sm btn-warning">Uredi</a>
              <a href="admin.php?brisi_dogodek=<?= $d["id"] ?>"
                 onclick="return confirm('Res izbriši?')"
                 class="btn btn-sm btn-danger">Briši</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="prijave">
      <h4>Prijave v čakanju</h4>
      <table class="table table-striped">
        <thead><tr><th>Član</th><th>Dogodek</th><th>Datum prijave</th><th>Akcije</th></tr></thead>
        <tbody>
          <?php if (mysqli_num_rows($prijave) == 0): ?>
            <tr><td colspan="4" class="text-muted">Ni prijav za odobritev</td></tr>
          <?php endif; ?>
          <?php while ($p = mysqli_fetch_assoc($prijave)): ?>
          <tr>
            <td><?= htmlspecialchars($p["ime"] . " " . $p["priimek"]) ?></td>
            <td><?= htmlspecialchars($p["d_naslov"]) ?></td>
            <td><?= date("d. m. Y", strtotime($p["datum_prijave"])) ?></td>
            <td>
              <a href="admin.php?potrdi=<?= $p["id"] ?>" class="btn btn-sm btn-success">Potrdi</a>
              <a href="admin.php?zavrni=<?= $p["id"] ?>" class="btn btn-sm btn-danger">Zavrni</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="objave">
      <h4>Dodaj objavo</h4>
      <form method="POST" class="row g-3 mb-4 p-3 border rounded bg-light">
        <div class="col-md-6">
          <input type="text" name="naslov_o" class="form-control" placeholder="Naslov *" required>
        </div>
        <div class="col-md-3">
          <select name="tip" class="form-select">
            <option value="novica">Novica</option>
            <option value="obvestilo">Obvestilo</option>
            <option value="zapisnik">Zapisnik</option>
            <option value="vabilo">Vabilo</option>
          </select>
        </div>
        <div class="col-12">
          <textarea name="vsebina" class="form-control" placeholder="Vsebina" rows="3"></textarea>
        </div>
        <div class="col-12">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="je_javna" id="javna" checked>
            <label class="form-check-label" for="javna">Javna objava</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="je_pomembna" id="pomembna">
            <label class="form-check-label" for="pomembna">Označi kot pomembno</label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" name="dodaj_objavo" class="btn btn-success">Objavi</button>
        </div>
      </form>

      <h4>Vse objave</h4>
      <table class="table table-striped">
        <thead><tr><th>Naslov</th><th>Tip</th><th>Javna</th><th>Pomembna</th><th>Akcije</th></tr></thead>
        <tbody>
          <?php while ($o = mysqli_fetch_assoc($objave)): ?>
          <tr>
            <td><?= htmlspecialchars($o["naslov"]) ?></td>
            <td><?= htmlspecialchars($o["tip"]) ?></td>
            <td><?= $o["je_javna"]?></td>
            <td><?= $o["je_pomembna"]?></td>
            <td>
              <a href="admin.php?brisi_objavo=<?= $o["id"] ?>"
                 onclick="return confirm('Res izbriši?')"
                 class="btn btn-sm btn-danger">Briši</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="clani">
      <h4>Vsi uporabniki</h4>
      <table class="table table-striped">
        <thead><tr><th>Ime</th><th>Username</th><th>Email</th><th>Vloga</th><th>Aktiven</th><th>Akcije</th></tr></thead>
        <tbody>
          <?php while ($c = mysqli_fetch_assoc($clani)): ?>
          <tr>
            <td><?= htmlspecialchars($c["ime"] . " " . $c["priimek"]) ?></td>
            <td><?= htmlspecialchars($c["username"]) ?></td>
            <td><?= htmlspecialchars($c["email"]) ?></td>
            <td><span class="badge <?= $c["vloga"] == "admin" ? "bg-danger" : ($c["vloga"] == "clan" ? "bg-success" : "bg-secondary") ?>">
              <?= htmlspecialchars($c["vloga"]) ?></span></td>
            <td><?= $c["aktiven"]?></td>
            <td>
              <a href="uredi_clana.php?id=<?= $c["id"] ?>" class="btn btn-sm btn-warning">Uredi</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
</main>

<footer class="bg-dark text-white text-center p-3 mt-5">
  <p class="mb-0">Moje društvo</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>