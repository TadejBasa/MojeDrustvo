<?php
session_start();
session_destroy();
?>

<script>
    sessionStorage.removeItem("jwt");
    window.location.href = "index.php";
</script>