<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <?php
        echo $_COOKIE["accept"];
        $set = isset($_COOKIE["accept"]);

        if (!$set) :
        ?>
            <form method="post">
                <input type="hidden" id="acc" name="acc" value="1">
                <input type="submit" name="accept" class="navdelete" value="Map Datenschutz zustimmen">
            </form>
        <?php
        endif;
        ?>

        <?php
        if ($set) :
        ?>
            <form method="post">
                <input type="hidden" id="notacc" name="notacc" value="1">
                <input type="submit" name="accept" class="navdelete" value="Map Datenschutz nicht zustimmen">
            </form>
        <?php
        endif;
        ?>


    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>

<?php
if (isset($_POST["acc"])) {
    echo "set";
    setcookie("accept", "set", time() + (86400 * 30), "/"); // 86400 = 1 day
}

if (isset($_POST["notacc"])) {
    echo "notset";
    unset($_COOKIE["accept"]);
    setcookie("accept", "", time() - 3600);
}
?>