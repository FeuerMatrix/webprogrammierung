<?php include_once "php/head.php" ?>

<body>

    <style>
        .pad {
            padding-left: 5%;
            padding-right: 5%;
        }

        @media screen and (min-width: 800px) {
            .pad {
                padding-left: 20%;
                padding-right: 20%;
            }
        }
    </style>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1 class="pad">Willkommen im Beschwerdeforum!</h1>

        <p class="pad">
            Der Nachbar hat seine Hecke nicht geschnitten?<br>
            Um 22:01 noch laut Musik gehört?<br>
            Oder gar den Müll falsch getrennt?<br>
            <br>
            Wenn du eins dieser Probleme kennst, bist du in diesem Forum richtig. Über all diese kleine Verbrechen, für die dein Nachbar nie seine wohlverdiente Strafe kriegt, und noch viele andere darf man sich hier herzlich auslassen.
        </p>
        <p class="pad">
            <a href="anmeldung.php">Melde dich an und leg los!</a>
        </p>
        <p class="pad">
            Hast du einen Account erstellt, so kannst du kannst du sogleich deinen ersten <a href="eintragneu.php">Beitrag erstellen.</a> Schreib dir das Leid aus dem Herz und hänge ausreichend Bild- oder Videomaterial als Beweis an.<br>
            Du kannst ebenfalls <a href="beitrag.php">von anderen Nutzern erstellten Einträgen</a> einsehen - dies geht sogar ohne Anmeldung!<br>
            Hast du Tipps, ein ähnliches Problem oder möchtest dich anderweitig beteiligen? Dann lass einfach ein Kommentar für den Beitrag da - der Ersteller wird sich sicher freuen!
        </p>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>