<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Registrieren</h1>

        <form>
            <fieldset>
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
                <input type="submit" name="register" value="Erstellen">
                <input type="button" name="cancel" value="Abbrechen"><br>
            </fieldset>
        </form>



    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>