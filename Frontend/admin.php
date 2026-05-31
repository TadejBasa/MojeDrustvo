<?php
require_once '../Backend/admin_backend.php';
// $jwtToken in $uporabnik sta ze nastavljena v admin_backend.php
$jwtEncoded = htmlspecialchars($jwtToken);
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
    <title>Admin - Moje Društvo</title>
</head>
<body>

<?php include 'header.php'; ?>

<script>
// Poskrbi da je JWT v sessionStorage (ker smo prišli morda prek redirect z ?jwt=)
(function() {
    const urlJwt = new URLSearchParams(window.location.search).get("jwt");
    if (urlJwt) {
        sessionStorage.setItem("jwt", urlJwt);
        // Pocisti URL brez reloada
        const url = new URL(window.location.href);
        url.searchParams.delete("jwt");
        history.replaceState(null, "", url.toString());
    }
})();
</script>

<main class="container py-4">
    <h2 class="mb-4">Admin panel</h2>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#dogodki">Dogodki</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prijave">Prijave</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#objave">Objave</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#clani">Clani</a></li>
    </ul>

    <div class="tab-content">

        <!-- DOGODKI -->
        <div class="tab-pane fade show active" id="dogodki">
            <h4 class="mb-3">Dodaj dogodek</h4>
            <form method="POST" enctype="multipart/form-data" class="row g-3 mb-4 p-3 border rounded bg-light">
                <input type="hidden" name="jwt" id="jwtDodajDogodek">
                <div class="col-md-6">
                    <label class="form-label">Naslov *</label>
                    <input type="text" name="naslov" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Datum in ura *</label>
                    <input type="datetime-local" name="datum_cas" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Lokacija</label>
                    <input type="text" name="lokacija" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Opis</label>
                    <textarea name="opis" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slika (URL)</label>
                    <input type="url" name="slika_url" class="form-control" placeholder="https://...">
                    <label class="form-label mt-2">ali naloži z računalnika</label>
                    <input type="file" name="slika_datoteka" class="form-control" accept="image/*">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cena (EUR)</label>
                    <input type="number" name="cena" class="form-control" min="0" step="0.01" value="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">St. mest</label>
                    <input type="number" name="st_mest" class="form-control" min="0" value="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Vrsta</label>
                    <select name="vrsta" class="form-select">
                        <option value="pohod">Pohod</option>
                        <option value="delavnica">Delavnica</option>
                        <option value="izlet">Izlet</option>
                        <option value="turnir">Turnir</option>
                        <option value="drugo">Drugo</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="je_javen" id="je_javen" checked>
                        <label class="form-check-label" for="je_javen">Javen dogodek</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" name="dodaj_dogodek" class="btn btn-success">Dodaj dogodek</button>
                </div>
            </form>

            <h4>Vsi dogodki</h4>
            <table class="table table-striped">
                <thead>
                    <tr><th>Naslov</th><th>Datum</th><th>Lokacija</th><th>Vrsta</th><th>Cena</th><th>Mest</th><th>Javen</th><th>Akcije</th></tr>
                </thead>
                <tbody>
                    <?php while ($dogodek = mysqli_fetch_assoc($vsi_dogodki)): ?>
                    <tr>
                        <td><?= htmlspecialchars($dogodek["naslov"]) ?></td>
                        <td><?= date("d. m. Y H:i", strtotime($dogodek["datum_cas"])) ?></td>
                        <td><?= htmlspecialchars($dogodek["lokacija"]) ?></td>
                        <td><?= htmlspecialchars($dogodek["vrsta"]) ?></td>
                        <td><?= $dogodek["cena"] > 0 ? number_format($dogodek["cena"], 2) . " EUR" : "Brezplacno" ?></td>
                        <td><?= $dogodek["st_mest"] ?></td>
                        <td><?= $dogodek["je_javen"] ? "Da" : "Ne" ?></td>
                        <td>
                            <a href="uredi_dogodek.php?id=<?= $dogodek["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" class="btn btn-sm btn-warning">Uredi</a>
                            <a href="admin.php?brisi_dogodek=<?= $dogodek["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" onclick="return confirm('Res izbrisi?')" class="btn btn-sm btn-danger">Brisi</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- PRIJAVE -->
        <div class="tab-pane fade" id="prijave">
            <h4>Prijave v cakanju</h4>
            <table class="table table-striped">
                <thead>
                    <tr><th>Clan</th><th>Dogodek</th><th>Datum prijave</th><th>Akcije</th></tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($prijave_cakanje) == 0): ?>
                        <tr><td colspan="4" class="text-muted">Ni prijav za odobritev.</td></tr>
                    <?php endif; ?>
                    <?php while ($prijava = mysqli_fetch_assoc($prijave_cakanje)): ?>
                    <tr>
                        <td><?= htmlspecialchars($prijava["ime"] . " " . $prijava["priimek"]) ?></td>
                        <td><?= htmlspecialchars($prijava["naziv_dogodka"]) ?></td>
                        <td><?= date("d. m. Y", strtotime($prijava["datum_prijave"])) ?></td>
                        <td>
                            <a href="admin.php?potrdi=<?= $prijava["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" class="btn btn-sm btn-success">Potrdi</a>
                            <a href="admin.php?zavrni=<?= $prijava["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" class="btn btn-sm btn-danger">Zavrni</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- OBJAVE -->
        <div class="tab-pane fade" id="objave">
            <h4 class="mb-3">Dodaj objavo</h4>
            <form method="POST" class="row g-3 mb-4 p-3 border rounded bg-light">
                <input type="hidden" name="jwt" id="jwtDodajObjavo">
                <div class="col-md-6">
                    <label class="form-label">Naslov *</label>
                    <input type="text" name="naslov_o" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tip</label>
                    <select name="tip" class="form-select">
                        <option value="novica">Novica</option>
                        <option value="obvestilo">Obvestilo</option>
                        <option value="vabilo">Vabilo</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Vsebina</label>
                    <textarea name="vsebina" class="form-control" rows="4"></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="je_javna" id="je_javna" checked>
                        <label class="form-check-label" for="je_javna">Javna objava</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="je_pomembna" id="je_pomembna">
                        <label class="form-check-label" for="je_pomembna">Pomembna</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" name="dodaj_objavo" class="btn btn-success">Objavi</button>
                </div>
            </form>

            <h4>Vse objave</h4>
            <table class="table table-striped">
                <thead>
                    <tr><th>Naslov</th><th>Tip</th><th>Javna</th><th>Pomembna</th><th>Datum</th><th>Akcije</th></tr>
                </thead>
                <tbody>
                    <?php while ($objava = mysqli_fetch_assoc($vse_objave)): ?>
                    <tr>
                        <td><?= htmlspecialchars($objava["naslov"]) ?></td>
                        <td><?= htmlspecialchars($objava["tip"]) ?></td>
                        <td><?= $objava["je_javna"] ? "Da" : "Ne" ?></td>
                        <td><?= $objava["je_pomembna"] ? "Da" : "Ne" ?></td>
                        <td><?= date("d. m. Y", strtotime($objava["datum_objave"])) ?></td>
                        <td>
                            <a href="admin.php?brisi_objavo=<?= $objava["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" onclick="return confirm('Res izbrisi?')" class="btn btn-sm btn-danger">Brisi</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- CLANI -->
        <div class="tab-pane fade" id="clani">
            <h4>Vsi uporabniki</h4>
            <table class="table table-striped">
                <thead>
                    <tr><th>Ime</th><th>Username</th><th>Email</th><th>Vloga</th><th>Aktiven</th><th>Akcije</th></tr>
                </thead>
                <tbody>
                    <?php while ($clan = mysqli_fetch_assoc($vsi_clani)): ?>
                    <tr>
                        <td><?= htmlspecialchars($clan["ime"] . " " . $clan["priimek"]) ?></td>
                        <td><?= htmlspecialchars($clan["username"]) ?></td>
                        <td><?= htmlspecialchars($clan["email"]) ?></td>
                        <td>
                            <span class="badge <?= $clan["vloga"] == "admin" ? "bg-danger" : ($clan["vloga"] == "clan" ? "bg-success" : "bg-secondary") ?>">
                                <?= htmlspecialchars($clan["vloga"]) ?>
                            </span>
                        </td>
                        <td><?= $clan["aktiven"] ? "Da" : "Ne" ?></td>
                        <td>
                            <a href="uredi_clana.php?id=<?= $clan["id"] ?>&jwt=<?= urlencode($jwtToken) ?>" class="btn btn-sm btn-warning">Uredi</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Vstavi JWT iz sessionStorage v vse skrite inpute
document.addEventListener("DOMContentLoaded", function () {
    const jwt = sessionStorage.getItem("jwt");
    if (!jwt) {
        window.location.href = "login.php";
        return;
    }
    document.querySelectorAll("input[type=hidden][id^=jwt]").forEach(el => el.value = jwt);
});
</script>
</body>
</html>