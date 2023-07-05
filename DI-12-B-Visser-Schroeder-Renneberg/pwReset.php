<?php
    include_once "path.php";
    include_once $path."/registrieren/controller_pwReset.php";
    include_once $path."/php/head.php"
?>

<link rel="stylesheet" href="css/pwReset.css">
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>
        <form method="POST">
            <div class="reg1">
                <h1 class="col10">Passwort zurücksetzten</h1>
                <div class="bottom"><p class="col20">Gib ein neues Passwort ein und bestätige es</p> </div>
                <label class="col11" for="passw">Passwort</label><br>
                <input class="col21" type="password" id="passw" name="passw" placeholder="Passwort" required autofocus><br>
                <label class="col12" for="passw2">Passwort bestätigen</label><br>
                <input class="col22" type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen" required><br>
                <input class="col13" type="submit" value="Erstellen">
            </div>
        </form>         
    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>