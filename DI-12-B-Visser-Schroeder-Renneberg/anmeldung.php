<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Anmelden</h1>

        <form>
            <fieldset>
            <label for="email">Email</label> <br>
            <input type="email" id="email" name="email" placeholder="Email" required autofocus> <br>
            <label for="pw">Passwort</label> <br>
            <input type="password" id="pw" name=pw placeholder="Passwort" required>
            </fieldset>
            <input type="button" name="cancel" value="Abbrechem">
            <input type="submit" name="login" value="Anmelden">
        </form>

    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>