<?php
require_once '../config.php';

/* DEBUG: katero bazo uporablja PHP */
$result = mysqli_query($conn, "SELECT DATABASE()");
$row = mysqli_fetch_row($result);
echo $row[0];
exit;

$dogodek_id = (int)$_GET['dogodek_id'];

$komentarji = mysqli_query(
    $conn,
    "SELECT * FROM komentar WHERE dogodek_id = $dogodek_id ORDER BY id DESC"
);

while ($k = mysqli_fetch_assoc($komentarji)):
?>
    <div class="border rounded p-2 mt-1 small">
        <?= htmlspecialchars($k['besedilo']) ?>
    </div>
<?php endwhile; ?>