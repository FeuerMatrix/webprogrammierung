<?php
    include_once "../../path.php";
    include_once $path."php/csrf.php";
    include_once $path."php/pwChange/controller_pwChange.php";
    include_once $path."php/head.php"
?>
<link rel="stylesheet" href="<?=$hpath?>css/registrieren.css" >
</head>

<body>

    <?php
        include_once $path."php/nav.php";

    ?>
    <main>
        <form method="POST">
        <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
                <div class="reg1">
                    <h1 class="col10">Daten Ändern</h1>
                    <div class="bottom"><p class="col20">Wähle ein neues Passwort und bestätige mit deinem alten Passwort.</p> </div>
                    <label class="col12" for="email">Email</label><br>
                    <input class="col22" type="email" id="email" name="email" placeholder="Email" value= "<?php echo $email ?>" readonly ><br>
                    <label class="col13" for="oldPw">altes Passwort</label><br>
                    <input class="col23" type="password" id="oldPw" name="oldPw" placeholder="altes Passwort" required autofocus><br>
                    <label class="col14" for="passw">Passwort</label><br>
                    <input class="col24" type="password" id="passw" name="passw" placeholder="Passwort" required><br>
                    <label class="col15" for="passw2">Passwort bestätigen</label><br>
                    <input class="col25" type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen" required><br>
                    <input class="col16" type="submit" value="Ändern">
                    <input class="col26" type="submit" form="form" value="Abbrechen"><br>
                </div>
        </form>
    </main>
    <form action="<?=$hpath?>index.php" id="form"></form>
    <?php include_once $path."php/footer.php" ?>
</body>

</html>