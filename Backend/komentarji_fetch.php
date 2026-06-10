<?php
require_once 'config.php';

$dogodek_id = (int)$_GET['dogodek_id'];

$q = mysqli_query($conn, "
    SELECT k.besedilo, u.username, u.profilna_slika
    FROM komentar k
    JOIN uporabnik u ON u.id = k.uporabnik_id
    WHERE k.dogodek_id = $dogodek_id
    ORDER BY k.id DESC
");

while ($k = mysqli_fetch_assoc($q)) {
    $slika = !empty($k['profilna_slika'])
        ? htmlspecialchars($k['profilna_slika'])
        : 'img/privzeta_slika.png';

    echo '
    <div class="d-flex align-items-start gap-2 border rounded p-2 mt-2 small komentar-blok">
        <img src="' . $slika . '"
             alt="Profil"
             style="width:32px; height:32px; border-radius:50%; object-fit:cover; flex-shrink:0;">
        <div>
            <span class="fw-semibold text-dark">'
                . htmlspecialchars($k['username']) .
            '</span>
            <p class="mb-0 text-muted">'
                . htmlspecialchars($k['besedilo']) .
            '</p>
        </div>
    </div>';
}