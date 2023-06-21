<link rel="stylesheet" href="css/nav.css">
<?php
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  if (!isset($abs_path)) include_once "path.php"; // Emergency Handling for when a page includes neither head.php nor path.php for whatever reason
?>
<nav>
  <div class="top-nav">
    <ul class="menu">
      <li><a href="index.php">Homepage</a></li>
      <li><a href="hauptseite.php">Beiträge</a></li>
      <?php if(isset($_SESSION["user"])):?>
      <li><a href="eintragneu.php">Neuer Beitrag</a></li>
      <li><a href="php/script_logout.php">Abmelden</a></li>
      <li><a href="pwChange.php">Daten anpassen</a></li>
      <li>
        <form method="post">
          <input type="hidden" id="delete" name="delete" value="1">
          <input type="submit" class = "navdelete" value="Nutzer Löschen">
      </form>
      </li>
      <?php else: ?>
      <li><a href="anmeldung.php">Anmelden</a></li>
      <li><a href="registrieren.php">Registrieren</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<noscript>
  <?php
    if(isset($_GET["cause"])):
  ?>
  <a><?php echo urldecode($_GET["cause"]); ?></a>
  <?php
    endif;
  ?>
</noscript>

<script>
const s = new URLSearchParams(location.search).get("cause");
if (s != null) {
alert(s);
}
</script>

  <?php
    if(isset($_POST["delete"])):
  ?>
  <a>Möchtest du deinen Account wirklich löschen?</a>
  <form action="script_dropUser.php">
    <input type="submit" class="navdelete" value="Nutzer Löschen">
  </form>
  <?php
    endif;
  ?>