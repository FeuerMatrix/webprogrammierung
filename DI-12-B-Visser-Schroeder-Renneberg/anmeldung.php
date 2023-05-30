<?php include_once "php/head.php" ?>
</head>

<body>
    <?php
        include_once "php/nav.php";
        
        function checkLoginData($email, $pw) {
            //TODO Database check: is pw correct? Needs Database Connection
            return $email == "tim@test.de" && $pw == "helloworld"; //Dummy Implementation
        }
        
        if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
            header("Location: index.php?cause=loggedIn");
            exit;
        }

        if(isset($_POST["email"], $_POST["pw"])) {
            unset($errorMessage);
            $email = htmlentities($_POST["email"]);
            $pw = htmlentities($_POST["pw"]);

            if(!checkLoginData($email, $pw)) {
                $errorMessage = "Ungültiges Passwort und/oder Email";
            }

            if(!isset($errorMessage)) {
                $_SESSION["user"] = "DummyValue"; //TODO get the actual user from the server
                header("Location: index.php");
                exit;
            }
        }
    ?>
    <main>

    <form method="post">
        <div class="reg">
        <h1>Anmelden</h1>
            <label for="email">Email</label> <br>
            <input type="email" id="email" name="email" placeholder="Email" required autofocus> <br>
            <label for="pw">Passwort</label> <br>
            <input type="password" id="pw" name=pw placeholder="Passwort" required>
            <input type="submit" class="create" value="Anmelden">
            <input type="button" class="cancel" value="Abbrechen">

            <?php if(isset($errorMessage)): ?> <!--Displays Messages for errors as well as successful registration, where the former has higher priority-->
                <a><?=$errorMessage?></a>
            <?php elseif(isset($_GET["from"])): ?> <!-- uses $_GET since get params can be directly put in with header()-->
                <a>Erfolgreich <?=($_GET["from"] == "registration" ? "Registriert" : "Abgemeldet")?>!</a>
            <?php endif; ?>
        </div>
        </form>
        
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>