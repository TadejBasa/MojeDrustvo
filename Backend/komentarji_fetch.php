<?php
require_once 'config.php';

$dogodek_id = (int)$_GET['dogodek_id'];

$q = mysqli_query($conn, "
    SELECT besedilo 
    FROM komentar 
    WHERE dogodek_id = $dogodek_id 
    ORDER BY id DESC
");

while ($k = mysqli_fetch_assoc($q)) {
    echo '<div class="border rounded p-2 mt-1 small">'
        . htmlspecialchars($k['besedilo']) .
    '</div>';
}