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