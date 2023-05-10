<?php include_once "php/head.php" ?>
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>>

        <div class="top">
            <h1>Beiträge</h1>
            <label for="suche">Suche</label>
            <input type="search" placeholder="Hier Suchbegriff eingeben" id="suche" required>
            <!-- <input type="submit" class="search" value="Suchen">-->
        </div>
        <div class="flex-container">
            <?php include "php/einzelBeitrag.php" ?>
            <?php include "php/einzelBeitrag.php" ?>
            <?php include "php/einzelBeitrag.php" ?>
        </div>

    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>