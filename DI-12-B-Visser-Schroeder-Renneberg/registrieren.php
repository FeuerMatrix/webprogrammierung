<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>
    <style>

    </style>

    <main>



        <form>
            <div class="reg">
                <h1>Registrieren</h1>
                <p>Fülle alle daten aus um dich zu Registrieren</p>
                <label for="user">Nutzername</label><br>
                <input type="text" id="user" name="user" placeholder="Nutzername" required autofocus><br>
                <label for="">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email" required><br>
                <label for="email2">Email bestätigen</label><br>
                <input type="email" id="email2" name="email2" placeholder="Email bestätigen" required><br>
                <label for="passw">Passwort</label><br>
                <input type="password" id="passw" name="passw" placeholder="Passwort" required><br>
                <label for="passw2">Passwort bestätigen</label><br>
                <input type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen" required><br>
                <input type="submit" class="create" value="Erstellen">
                <input type="button" class="cancel" value="Abbrechen"><br>
            </div>
        </form>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>