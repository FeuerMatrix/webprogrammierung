<?php
    include_once "../path.php";
    session_start();
    session_destroy();
    header("Location: ".$hpath."anmeldung.php?from=logout");
    exit;
?>