<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Document</title>

    <style>
    footer a {
        color: inherit;
        text-decoration: none;}
    </style>
</head>
<body>
  
<?php include 'header.php'; ?>

<section class="welcome">
  <div class="container-uvod">
    <div class="welcome-vsebina">

      <h1>Dobrodošli</h1>
      <p>Spremljajte prihajajoče dogodke in aktivnosti!</p>
    
    </div>
  </div>
</section>

<section class="events">
  <div class="container-events">
    <div class="events-vsebina">
      <h2>
        Prihajajoči dogodki
      </h2>

      <div
        class="row g-4"
        id="dogodki-container"></div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>