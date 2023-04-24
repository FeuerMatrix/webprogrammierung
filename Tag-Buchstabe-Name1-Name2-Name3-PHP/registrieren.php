<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Registrieren</h1>

        <form>
        <fieldset>
        <input type="text" name="user" placeholder="Nutzername">
        <input type="email" name="email" placeholder="Email">
        <input type="email" name="email2" placeholder="Email bestätigen">
        <input type="password" name="passw" placeholder="Passwort">
        <input type="password" name="passw2" placeholder="Passwort bestätigen">
        <input type="submit" value="Submit">
        <input type="submit" value="Abbrechen">
</fieldset>
        </form>



    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>