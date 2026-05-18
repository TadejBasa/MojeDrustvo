<?php
session_start();
require_once 'config.php';

$napaka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vhod  = trim($_POST["vhod"]);
    $geslo = $_POST["geslo"];

    if (empty($vhod) || empty($geslo)) {
        $napaka = "Prosim izpolni vsa polja.";
    } else {
        $sql  = "SELECT * FROM uporabnik WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $vhod, $vhod);
        mysqli_stmt_execute($stmt);
        $rezultat  = mysqli_stmt_get_result($stmt);
        $uporabnik = mysqli_fetch_assoc($rezultat);

        if ($uporabnik && password_verify($geslo, $uporabnik["geslo_hash"])) {
            $_SESSION["uporabnik_id"] = $uporabnik["id"];
            $_SESSION["ime"]          = $uporabnik["ime"];
            $_SESSION["username"]     = $uporabnik["username"];
            $_SESSION["vloga"]        = $uporabnik["vloga"];

            if ($uporabnik["vloga"] == "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $napaka = "Napačno uporabniško ime/email ali geslo.";
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
    <title>Prijava - Moje Društvo</title>
</head>
<body class="stran">

<?php include 'header.php';?>

<main>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card shadow p-4">
          <h2 class="mb-4 text-center">Prijava</h2>

          <?php if ($napaka): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($napaka) ?></div>
          <?php endif; ?>

          <form method="POST" action="login.php">
            <div class="mb-3">
              <label class="form-label">Uporabniško ime ali email</label>
              <input type="text" name="vhod" class="form-control" required
                     value="<?= htmlspecialchars($_POST['vhod'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Geslo</label>
              <input type="password" name="geslo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Prijava</button>
          </form>

          <hr>
          <p class="text-center mb-0">
            Nimaš računa?
            <a href="register.php">Registracija</a>
          </p>
        </div>

      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>