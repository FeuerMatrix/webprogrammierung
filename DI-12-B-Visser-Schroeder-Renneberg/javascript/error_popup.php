<script>
  const s = new URLSearchParams(location.search).get("cause");
    if (s != null) {
        document.getElementById("errorbox").innerHTML = s;
        setTimeout((() => document.getElementById("errorbox").innerHTML = ""), 3000)
    }
</script>