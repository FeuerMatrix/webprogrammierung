<?php
    include_once "../path.php";
    session_start();
    session_destroy();
    header("Location: ".$hpath."php/anmeldung/anmeldung.php?from=logout");
    exit;
?>