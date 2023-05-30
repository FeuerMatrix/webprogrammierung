<link rel="stylesheet" href="css/registrieren.css" >
<?php include_once "php/head.php" ?>
</head>
    <?php
        

        if(isset($_POST["passw"], $_POST["passw2"], $_POST["user"], $_POST["email"], $_POST["email2"])) {
            foreach($_POST as $postKey=>$postElement) {
                $$postKey = $_POST[$postKey];
            }

            if($email != $email2) {
                $errorMessage = "Email-Addressen stimmen nicht überein!";
            }

            if($passw != $passw2) {
                $errorMessage = "Passwörter stimmen nicht überein!";
            }
            
            if(!isset($errorMessage)) {
                //TODO email verification

                //TODO Database query does username already exist

                //TODO Database Insertion

                //TODO success notification on login page

                header("Location: anmeldung.php");
                exit;
            }
        }
    ?>
<body>

    <?php include_once "php/nav.php" ?>
    
    <main>
    
        <form method="post">
                <div class="reg1">
                    <h1 class="col10">Registrieren</h1>
                    <div class="bottom"><p class="col20">Fülle alle daten aus um dich zu Registrieren</p> </div>
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