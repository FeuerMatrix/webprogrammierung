<link rel="stylesheet" href="css/hauptseite.css" >
<?php include_once "php/head.php" ?>
</head>

<?php
$suche = (isset($_GET["suche"]) && is_string($_GET["suche"])) ? $_GET["suche"] : "";
$sort = (isset($_GET["sort"]) && is_string($_GET["sort"])) ? $_GET["sort"] : "date";

// Beispieldaten
$beitraege = array(
    array('id' => 1, 'titel' => 'Argumentation', 'date' => '05.06.1996' , 'file' => 'images/beispielbilder/argumentation.png', 'pname' => 'Argumentation' ),
    array('id' => 2, 'titel' => 'Protest', 'date' => '08.04.1976' , 'file' => 'images/beispielbilder/protest.png', 'pname' => 'Protest'),
    array('id' => 3, 'titel' => 'Trouble Incoming', 'date' => '08.05.1976', 'file' => 'images/beispielbilder/trouble.jpg', 'pname' => 'Trouble Schilder'),
    array('id' => 4, 'titel' => 'Beispielbild', 'date' => '08.04.1976' , 'file' => '', 'pname' => '')
);

// Nur Beiträge anzeigen, die den Suchbegriff im Titel enthalten
if ($suche != "") {
    $beitraege = array_filter($beitraege, function ($beitrag) use ($suche) {
        return strpos($beitrag['titel'], $suche) !== false;
    });
}

//Sortieren der Foreneinträge
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
?>

<body>
    <?php include_once "php/nav.php" ?>

    <main>
        <div class="top">
            <h1>Beiträge</h1>
            <form> 
                <label for="suche">Suche</label> <br>
                <input type="search" name="suche" placeholder="Hier Suchbegriff eingeben" id="suche"> <br>
                <label for="sort">Sortieren nach:</label> <br>
                <select id="sort" name="sort" require>
                    <option value="date">Datum</option>
                    <option value="titel">Alphabetisch</option>
                </select> <br>
                <input type="submit" value="Auswahl bestätigen">
            </form>
        </div>

        <div class="flex-container">

                <?php foreach ($beitraege as $beitrag): ?>   
                       
                       <div class="beitrag">
                            <a class="link" href=<?php echo "beitrag.php?id=".$beitrag["id"] ?> > <?php echo $beitrag['titel'] ?></a>
                            <span> <?php echo $beitrag['date'] ?></span>
                            <img src=<?php echo $beitrag['file'] ?>  alt= <?php echo $beitrag['pname'] ?> >
                        </div>
                <?php endforeach ?>
   
        </div>

    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>