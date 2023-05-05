<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <style>
        .flex-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="search"] {
            padding: 16px;
            max-width: 400px;
        }

        .top {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgb(90, 90, 90);
            border-radius: 25px;
            padding-bottom: 20px;
        }
    </style>

    <main>>
        <div class="top">
            <h1>Beiträge</h1>
            <label for="suche">Suche</label>
            <input type="search" placeholder="Hier suche Eingeben" id="suche" required>
            <!-- <input type="submit" class="search" value="Suchen">-->
        </div>


        <div class="flex-container">
            <?php include "php/beitrag.php" ?>
            <?php include "php/beitrag.php" ?>
            <?php include "php/beitrag.php" ?>
        </div>
    </main>
    <?php include_once "php/footer.php" ?>
</body>

</html>