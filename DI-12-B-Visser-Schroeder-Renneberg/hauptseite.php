<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Beiträge</h1>
        <form>
            <label for="suche">Suche</label>
            <input type="search" id="suche" required>
            <input type="submit" value="suchen">
        </form>
        <table>
            <tr>
                <th>
                    <fieldset>
                        <a href="beitrag.php">Testbeitrag 1</a>
                        <img src="images/guestbook.png" alt="Beispielbild">
                        <span>Datum</span>
                    </fieldset>
                </th>
            </tr>
            <tr>
                <th>
                    <fieldset>
                        <a href="beitrag.php">Testbeitrag 2</a>
                        <img src="images/guestbook.png" alt="Beispielbild">
                        <span>Datum</span>
                    </fieldset>
                </th>
            </tr>
            <tr>
                <th>
                    <fieldset>
                        <a href="beitrag.php">Testbeitrag 3</a>
                        <img src="images/guestbook.png" alt="Beispielbild">
                        <span>Datum</span>
                    </fieldset>
                </th>
            </tr>
        </table>

    </main>
    <?php include_once "php/footer.php" ?>
</body>

</html>