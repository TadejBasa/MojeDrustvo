<?php
require_once 'config.php';

$napaka = "";
$uspeh = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = trim($_POST["ime"]);
    $priimek = trim($_POST["priimek"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $geslo = $_POST["geslo"];
    $datum_rojstva = $_POST["datum_rojstva"];

    $geslo_hash = password_hash($geslo, PASSWORD_DEFAULT);
    $vloga = "clan";

    $sql = "INSERT INTO uporabnik
    (ime, priimek, username, email, geslo_hash, vloga, datum_rojstva)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $ime,
        $priimek,
        $username,
        $email,
        $geslo_hash,
        $vloga,
        $datum_rojstva
    );

    mysqli_stmt_execute($stmt);

    $uspeh = "Registracija uspešna";
}
?>

<!DOCTYPE html>
<html class="html" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Registracija - Moje Društvo</title>
</head>
<body class="stran html">

<?php include 'header.php'; ?>

<main>
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="registracijaForm" method="POST" action="register.php">
        <div class="mb-3">
          <div id="vseError"></div>
          <label for="ime" class="form-label">Ime</label>
          <input type="text" class="form-control" id="ime" name="ime">
          <div id="imeError"></div>
        </div>
        <div class="mb-3">
          <label for="priimek" class="form-label">Priimek</label>
          <input type="text" class="form-control" id="priimek" name="priimek">
          <div id="priimekError"></div>
        </div>
        <div class="mb-3">
          <label for="uporabniskoIme" class="form-label">Uporabniško ime</label>
          <input type="text" class="form-control" id="uporabniskoIme" name="username">
          <div id="uporabniskoError"></div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email">
          <div id="emailError"></div>
        </div>
        <div class="mb-3">
          <label for="geslo" class="form-label">Geslo</label>
          <input type="password" class="form-control" id="geslo" name="geslo">
          <div id="gesloError"></div>
        </div>
        <div class="mb-3">
          <label for="datumRojstva" class="form-label">Datum rojstva</label>
          <input type="date" class="form-control" id="datumRojstva" name="datum_rojstva">
          <div id="rojstvoError"></div>
        </div>
        <button type="submit" class="btn btn-success btn-primary w-100">
          Registracija
        </button>
      </form>
    </div>
  </div>
</div>
</main>

<?php include 'footer.php'; ?>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="registracija.js" defer></script>
</html>