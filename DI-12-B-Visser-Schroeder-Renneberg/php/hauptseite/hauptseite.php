<?php 
    include_once "../../path.php";
    include_once $path."php/hauptseite/controller_hauptseite.php";
    include_once $path."php/head.php";
?>
<link rel="stylesheet" href="<?=$hpath?>css/hauptseite.css">

</head>

<body>
    <?php include_once $path."php/nav.php" ?>

    <main>
        <div class="top">
            <h1>Beiträge</h1>
            <form>
                <label for="suche">Suche</label> <br>
                <input id="suche" type="search" name="suche" placeholder="Hier Suchbegriff eingeben"> <br>
                <label for="sort">Sortieren nach:</label> <br>
                <select id="sort" name="sort">
                    <option value="date">Datum</option>
                    <option value="titel">Alphabetisch</option>
                </select> <br>
            </form>
        </div>

        <div class="flex-container">
            <?php foreach ($beitraege as $beitrag) : ?>
                <div class="beitrag">
                    <a class="link" href="<?=$hpath?>php/beitrag/beitrag.php?id=<?php echo urlencode($beitrag["id"]) ?>"> <?php echo $beitrag['titel'] ?></a>
                    <span class="center"> <?php echo date("Y-m-d H:i:s", $beitrag['date']); ?></span>
                    <?php
                    if ($beitrag['file'] != "") {
                    ?>
                        <img class="center, img" src=<?php echo $hpath.$beitrag['file'] ?> alt=<?php echo $beitrag['pname'] ?>>
                    <?php
                    }
                    ?>
                </div>
            <?php endforeach ?>
        </div>

    </main>

    <?php include_once $path."php/footer.php" ?>

    <script src="<?=$hpath?>javascript/jquery.min.js"></script>
    <?php include_once $path."javascript/fetch_beitraege.php" ?>
</body>

</html>



