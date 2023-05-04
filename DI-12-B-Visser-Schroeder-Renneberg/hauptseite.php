<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <style>


        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            background-color: rgb(235, 235, 235);
            flex-direction: column;
            align-items: center
        }
    </style>



    <main>>
        <h1 class="center">Beiträge</h1>
        <div>
            <label for="suche">Suche</label>
            <input  type="search" placeholder="Hier suche Eingeben" id="suche" required>
           <!-- <input type="submit" class="search" value="Suchen">-->
        </div>


        <div class="flex-container">
            <div> <?php include "php/beitrag.php" ?></div>
            <div> <?php include "php/beitrag.php" ?></div>
            <div><?php include "php/beitrag.php" ?></div>
        </div>
    </main>
    <?php include_once "php/footer.php" ?>
</body>

</html>