<!DOCTYPE html>
<html lang="sl">

<?php
$conn = mysqli_connect("localhost", "root", "", "moje_drustvo");

$sql = "SELECT * FROM objave";
$result = mysqli_query($conn, $sql);
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Objave</title>
  
  <style>
    footer a {
        color: inherit;
        text-decoration: none;}
    </style>
</head>

<body>

<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">
        <img src="slike/logo_placeholder.png" alt="Domov" width="100" height="100" loading="eager"> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.html">Domov</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="objave.html">Objave</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.html">Prijava</a>
        </li>
      </ul>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
      <button class="btn btn-outline-success" type="submit">Išči</button>
    </form>
</div>
</div>
</nav>
</header>

<div class="container py-5">

  <h2 class="mb-4">Objave</h2>

    <div class="row g-4">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

  <?php
  $border = "border-secondary";
  $badge = "bg-secondary";

  if ($row["tip"] == "dogodek") {
    $border = "border-success";
    $badge = "bg-success";
  } 
  else if ($row["tip"] == "novica") {
    $border = "border-primary";
    $badge = "bg-primary";
  }
  else {
    $border = "border-danger";
    $badge = "bg-danger";
  }
  ?>

  <div class="col-md-4">
    <div class="card shadow-sm h-100 border-start border-3 <?php echo $border; ?>">
      <div class="card-body p-4">

        <span class="badge <?php echo $badge; ?> mb-2">
          <?php echo $row["tip"]; ?> </span>

        <h5><?php echo $row["naslov"]; ?></h5>
        <p><?php echo $row["opis"]; ?></p>

      </div>
    </div>
  </div>

<?php } ?>

</div>
</div>

<footer class="bg-dark text-white pt-5 pb-4">
  <div class="container text-center text-md-start">
    <div class="row">

      <!-- about -->
      <div class="col-md-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4">Moje društvo</h5>
        <p>Spremljajte dogodke, novice in obvestila društva.</p>
      </div>

      <!-- posts -->
      <div class="col-md-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4">Objave</h6>
        <p><a href="#">Dogodki</a></p>
        <p><a href="#">Novice</a></p>
        <p><a href="#">Obvestila</a></p>
      </div>

      <!-- navigation -->
      <div class="col-md-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4">Navigacija</h6>
        <p><a href="index.html">Domov</a></p>
        <p><a href="objave.html">Objave</a></p>
        <p><a href="login.html">Prijava</a></p>
      </div>

      <!-- contact -->
      <div class="col-md-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4">Kontakt</h6>
        <p>Email: drustvo@place_holder.si</p>
        <p>Slovenija</p>
      </div>

    </div>

    <div class="row pt-3 border-top mt-3">
      <p class="text-center mb-0">© 2026 Moje društvo</p>
    </div>

  </div>
</footer>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>