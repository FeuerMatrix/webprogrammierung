<?php
    include_once "path.php";
    include_once $path."/registrieren/controller_confirmEmail.php";
    include_once $path."/php/head.php"
?>

<link rel="stylesheet" href="css/confirmEmail.css">
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>
        <div class="reg">
            <h1 class="col10">Email bestätigen</h1>
            <?php if($confirmed):?>
                <p> Email wurde erfolgreich bestätigt. Hier gehts zur <a href="anmeldung.php">Anmeldung.</a> </p> 
            <?php else: ?>
                <p> Der Link zur Bestätigung der Email ist leider abgelaufen. </p>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>