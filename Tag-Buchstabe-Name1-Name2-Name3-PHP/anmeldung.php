<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Anmelden</h1>

        <form>
            <fieldset>
            <input type="email" name="email" placeholder="Email">
            <input type="password" name=pw placeholder="Passwort">
            </fieldset>
            <input type="submit" name="cancel" value="Abbrechem">
            <input type="submit" name="login" value="Anmelden">
            
        </form>

    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>