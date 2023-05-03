<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Registrieren</h1>

        <form>
            <fieldset>
                <label for="user">Nutzername</label><br>
                <input type="text" id="user" name="user" placeholder="Nutzername"><br>
                <label for="">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email"><br>
                <label for="email2">Email bestätigen</label><br>
                <input type="email" id="email2" name="email2" placeholder="Email bestätigen"><br>
                <label for="passw">Passwort</label><br>
                <input type="password" id="passw" name="passw" placeholder="Passwort"><br>
                <label for="passw2">Passwort bestätigen</label><br>
                <input type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen"><br>
                <input type="submit" value="Erstellen">
                <input type="submit" value="Abbrechen"><br>
            </fieldset>
        </form>



    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>