<?php
    session_start();
    session_destroy();
    header("Location: ../anmeldung.php?from=logout");
    exit;
?>