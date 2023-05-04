<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>



    <main>

        <h1 class="center">Anmelden</h1>

        <form>
        <div class="reg">
            <label for="email">Email</label> <br>
            <input type="email" id="email" name="email" placeholder="Email" required autofocus> <br>
            <label for="pw">Passwort</label> <br>
            <input type="password" id="pw" name=pw placeholder="Passwort" required>
            <input type="submit" class="create" value="Anmelden">
            <input type="button" class="cancel" value="Abbrechem">
        </div>
        </form>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>