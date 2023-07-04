<script>
  const s = new URLSearchParams(location.search).get("cause");
    if (s != null) {
        document.getElementById("errorbox").innerHTML = s;
          document.getElementById("errorpopup").className = "errorpopup";
        setTimeout((() => {
          document.getElementById("errorbox").innerHTML = "";
          document.getElementById("errorpopup").className = "";
        }), 3000)
    }
</script>