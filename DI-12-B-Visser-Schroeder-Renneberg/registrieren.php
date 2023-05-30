<link rel="stylesheet" href="css/registrieren.css" >
<?php include_once "php/head.php" ?>
</head>

<body>

    <?php
        include_once "php/nav.php";
        function checkUserNameExists($user) {
            //TODO Database query: does username already exist
            return false; //Dummy return value
        }

        if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
            header("Location: index.php?cause=loggedIn");
            exit;
        }

        if(isset($_POST["passw"], $_POST["passw2"], $_POST["user"], $_POST["email"], $_POST["email2"])) {
            unset($errorMessage);
            foreach($_POST as $postKey=>$postElement) {
                $$postKey = htmlentities($_POST[$postKey]);
            }

            if($email != $email2) {
                $errorMessage = "Email-Addressen stimmen nicht überein!";
            }

            if($passw != $passw2) {
                $errorMessage = "Passwörter stimmen nicht überein!";
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "Fehlerhafte Email-Addresse!";
            }

            if(checkUserNameExists($email)) {
                $errorMessage = "Benutzername existiert bereits/Email bereits in Benutzung!";
            }

            if(!isset($errorMessage)) {
                //TODO Database Insertion
                header("Location: anmeldung.php?from=registration");
                exit;
            }
        }
    ?>
    <main>
    
        <form method="post">
                <div class="reg1">
                    <h1 class="col10">Registrieren</h1>
                    <div class="bottom"><p class="col20">Fülle alle Daten aus, um dich zu Registrieren</p> </div>
                    <label class="col11" for="user">Nutzername</label><br>
                    <input class="col21" type="text" id="user" name="user" placeholder="Nutzername" required autofocus><br>
                    <label class="col12" for="email">Email</label><br>
                    <input class="col22" type="email" id="email" name="email" placeholder="Email" required><br>
                    <label class="col13" for="email2">Email bestätigen</label><br>
                    <input class="col23" type="email" id="email2" name="email2" placeholder="Email bestätigen" required><br>
                    <label class="col14" for="passw">Passwort</label><br>
                    <input class="col24" type="password" id="passw" name="passw" placeholder="Passwort" required><br>
                    <label class="col15" for="passw2">Passwort bestätigen</label><br>
                    <input class="col25" type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen" required><br>
                    <input class="col16" type="submit" value="Erstellen">
                    <input class="col26" type="button" value="Abbrechen"><br>

                    <?php if(isset($errorMessage)): ?>
                        <a><?=$errorMessage?></a>
                    <?php endif; ?>
                </div>
        </form>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>