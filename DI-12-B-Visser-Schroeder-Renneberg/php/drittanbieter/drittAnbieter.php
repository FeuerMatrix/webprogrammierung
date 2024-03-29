<?php 
    include_once "../../path.php";
    include_once $path."php/csrf.php";
    include_once $path."php/drittAnbieter/controller_drittAnbieter.php";    
    include_once $path."php/head.php";
?>
<link rel="stylesheet" href="<?=$hpath?>css/index.css">
</head>

<body>

    <?php include_once $path."php/nav.php" ?>

    

    <main>
    <p>Um ein Karte anzuzeigen, auf der ein Ort markiert werden kann, wird OpenStreetMap benutzt. <br> Zustimmungen zu Drittanbietern werden in Cookies gespeichert, <br> weitere Infos hierzu finden Sie im <a href="<?=$hpath?>php/datenschutz.php">Datenschutz</a>.</p>
        <a href="https://www.openstreetmap.org/about">OpenStreetMap Info</a>
        <?php
        if (!$set) :
        ?>
            <form method="post">
                <input type="hidden" id="acc" name="acc" value="1">
                <input type="submit" name="accept" class="navdelete" value="OpenStreetMap Datenschutz zustimmen">
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
                <input type="submit" name="accept" class="navdelete" value="OpenStreetMap Datenschutz nicht zustimmen">
                <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
            </form>
        <?php
        endif;
        ?>


    </main>

    <?php include_once $path."php/footer.php" ?>
</body>

</html>