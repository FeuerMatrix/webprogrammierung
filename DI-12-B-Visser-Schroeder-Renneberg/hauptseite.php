<link rel="stylesheet" href="css/hauptseite.css" >
<?php include_once "php/head.php" ?>
</head>

<body>
    <?php include_once "php/nav.php" ?>

    <main>
        <div class="top">
            <h1>Beiträge</h1>
            <form> 
                <label for="suche">Suche</label> <br>
                <input type="search" placeholder="Hier Suchbegriff eingeben" id="suche"> <br>
                <label for="sort">Sortieren nach:</label> <br>
                <select id="sort" name="sort" require>
                    <option value="date">Datum</option>
                    <option value="titel">Alphabetisch</option>
                </select> <br>
                <input type="submit" value="Auswahl bestätigen">
            </form>
        </div>

        <div class="flex-container">

            <?php

                // Beispieldaten
                $beitraege = array(
                    array('id' => 1, 'titel' => 'Argumentation', 'date' => '05.06.1996' , 'file' => 'images/beispielbilder/argumentation.png', 'pname' => 'Argumentation' ),
                    array('id' => 2, 'titel' => 'Protest', 'date' => '08.04.1976' , 'file' => 'images/beispielbilder/protest.png', 'pname' => 'Protest'),
                    array('id' => 3, 'titel' => 'Trouble Incoming', 'date' => '08.05.1976', 'file' => 'images/beispielbilder/trouble.jpg', 'pname' => 'Trouble Schilder'),
                    array('id' => 4, 'titel' => 'Beispielbild', 'date' => '08.04.1976' , 'file' => '', 'pname' => '')
                );

                
                // Nur Beiträge anzeigen, die den Suchbegriff im Titel enthalten
                $suchbegriff = "";
                if ($suchbegriff != "") {
                    $beitraege = array_filter($beitraege, function ($beitrag) use ($suchbegriff) {
                        return strpos($beitrag['titel'], $suchbegriff) !== false;
                    });
                }
                

                //Sortieren der Foreneinträge
                $sort = "titel";

                switch ($sort) {
                    case "date": 
                        usort($beitraege, 'sortiereNachDatum');
                        break;
                    case "titel":
                        usort($beitraege, 'sortiereNachTitel');
                        break;
                    default:
                        echo "Ungültige auswahl der Sortierung";
                        break;
                }
                
                function sortiereNachTitel($a, $b) {                        // Vergleich nach Titel
                    return strcmp($a['titel'], $b['titel']);
                }

                
                function sortiereNachDatum($a, $b) {                        // Funktion nach Datum
                    $dateA = strtotime($a['date']);                         //strtotime wandelt das Datum in einen int um
                    $dateB = strtotime($b['date']);
                
                    if ($dateA == $dateB) {
                        return 0;
                    }
                    return ($dateA < $dateB) ? 1 : -1;                      // 1 wenn true, -1 wenn false
                }

                //Foreneinträge erstellen
                function beitragErstellen($id, $titel, $date, $file = "images/guestbook.png", $pname = "Beispielbild"){
                    if ($file == '') {
                        $file = "images/guestbook.png";
                        $pname = "Beispielbild";
                    }
                    $url = "beitrag.php?id=".$id;
                    ?>
                        <div class="beitrag">
                            <a class="link" href=<?php echo $url ?> > <?php echo $titel ?></a>
                            <span> <?php echo $date ?></span>
                            <img src=<?php echo $file ?>  alt= <?php echo $pname ?> >
                        </div>
                <?php
                }

                foreach ($beitraege as $beitrag) {
                    beitragErstellen($beitrag["id"],$beitrag['titel'], $beitrag['date'], $beitrag['file']);
                }
            ?>
   
        </div>

    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>