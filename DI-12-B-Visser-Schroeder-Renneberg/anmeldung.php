<?php include_once "php/head.php" ?>
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

    <form>
        <div class="reg">
        <h1>Anmelden</h1>
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