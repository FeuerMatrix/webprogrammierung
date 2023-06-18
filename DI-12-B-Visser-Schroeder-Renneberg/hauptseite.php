<?php include_once "php/controller_hauptseite.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/hauptseite.css" >

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#suche, #sort").on("input change", function() {
        var search = $("#suche").val(); // Lese den Suchbegriff aus dem Eingabefeld
        var sort = $("#sort").val(); // Lese den Wert der Sortierungs-Option aus dem Dropdown-Menü

        // Sende Ajax-Anfrage an den Server
        $.ajax({
            type: "GET",
            url: "php/search.php",
            async: true,
            data: { search: search, sort: sort },
            dataType: "json",
            success: function(data) {
                var container = $(".flex-container");
                container.empty(); // Leere den Inhalt der flex-container

                // erstelle neue Beitragselemente
                $.each(data, function(index, beitrag) {
                    var beitragDiv = $("<div>").addClass("beitrag");
                    var link = $("<a>").addClass("link").attr("href", "beitrag.php?id=" + encodeURIComponent(beitrag.id)).text(beitrag.titel);
                    var dateSpan = $("<span>").text(new Date(beitrag.date * 1000).toLocaleString());
                    var img = $("<img>").attr("src", beitrag.file).attr("alt", beitrag.pname);

                    beitragDiv.append(link, dateSpan, img);
                    container.append(beitragDiv);
                });
            }
        });
    });
});
</script>


</head>

<body>
    <?php include_once "php/nav.php" ?>

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
                <?php foreach ($beitraege as $beitrag): ?>         
                       <div class="beitrag">
                            <a class="link" href=<?php echo "\"beitrag.php?id=".urlencode($beitrag["id"])."\"" ?> > <?php echo $beitrag['titel'] ?></a>
                            <span> <?php echo date("Y-m-d H:i:s",$beitrag['date']); ?></span>
                            <img src=<?php echo $beitrag['file'] ?>  alt= <?php echo $beitrag['pname'] ?> >
                        </div>
                <?php endforeach ?>
        </div>

    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>