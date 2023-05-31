<link rel="stylesheet" href="css/nav.css">
<?php
  session_start();
  if (!isset($abs_path)) include_once "path.php"; // Emergency Handling for when a page includes neither head.php nor path.php for whatever reason
?>
<nav>
  <div class="top-nav">
    <input id="menu-toggle" type="checkbox" />
    <label class='menu-button-container' for="menu-toggle">
    <div class='menu-button'></div>
    </label>
    <ul class="menu">
      <li><a href="index.php">Homepage</a></li>
      <li><a href="hauptseite.php">Beiträge</a></li>
      <?php if(isset($_SESSION["user"])):?>
      <li><a href="eintragneu.php">Neuer Beitrag</a></li>
      <li><a href="php/script_logout.php">Abmelden</a></li>
      <?php else: ?>
      <li><a href="anmeldung.php">Anmelden</a></li>
      <li><a href="registrieren.php">Registrieren</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<?php
  if(isset($_GET["cause"])):
?>
<a><?php echo urldecode($_GET["cause"]); ?></a>
  <?php
  endif;
  ?>