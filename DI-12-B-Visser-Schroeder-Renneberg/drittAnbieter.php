<?php include_once "php/csrf.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <?php

    if (isset($_POST["acc"])) {
        if (!validCSRF($_POST)) {
            header("Location: index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        setcookie("accept", "set", time() + (86400 * 30), "/"); // 86400 = 1 day
        header("Location: hauptseite.php");
        exit;
    }

    if (isset($_POST["notacc"])) {
        if (!validCSRF($_POST)) {
            header("Location: index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        setcookie("accept", "", time() - 3600, "/");
        unset($_COOKIE["accept"]);
        header("Location: hauptseite.php");
        exit;
    }

    $set = isset($_COOKIE["accept"]);
    ?>

    <main>
    <p>Um ein Karte anzuzeigen auf der ein Ort Markiert werden kann OpenStreetMaps benutzt. </p>
        <a href="https://www.openstreetmap.org/about">OpenStreetMap Info</a>
        <?php
        if (!$set) :
        ?>
            <form method="post">
                <input type="hidden" id="acc" name="acc" value="1">
                <input type="submit" name="accept" class="navdelete" value="OpenStreetMaps Datenschutz zustimmen">
                <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
            </form>
        <?php
        endif;
        ?>

        <?php
        if ($set) :
        ?>
            <form method="post">
                <input type="hidden" id="notacc" name="notacc" value="1">
                <input type="submit" name="accept" class="navdelete" value="OpenStreetMaps Datenschutz nicht zustimmen">
                <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
            </form>
        <?php
        endif;
        ?>


    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>