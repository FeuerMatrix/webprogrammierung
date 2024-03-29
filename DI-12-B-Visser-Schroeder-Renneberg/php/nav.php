<?php include_once "csrf.php" ?>
<link rel="stylesheet" href="<?=$hpath?>css/nav.css">
<?php
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  if(!isset($path))include_once "path.php";
?>
<nav>
  <div class="top-nav">
    <input id="menu-toggle" type="checkbox">
    <div class='menu-button-container'>
    <label class='menu-button' for="menu-toggle">
      
    </label>
    </div>
    <ul class="menu">
      <li><a href="<?=$hpath?>index.php">Homepage</a></li>
      <li><a href="<?=$hpath?>php/hauptseite/hauptseite.php">Beiträge</a></li>
      <?php if(isset($_SESSION["user"])):?>
      <li><a href="<?=$hpath?>php/beitragErstellen/eintragneu.php">Neuer Beitrag</a></li>
      <li><a href="<?=$hpath?>php/script_logout.php">Abmelden</a></li>
      <li><a href="<?=$hpath?>php/pwChange/pwChange.php">Daten anpassen</a></li>
      <li>
        <form method="post">
          <input type="hidden" id="deleteUser" name="deleteUser" value="1">
          <input type="submit" class = "navdelete" value="Nutzer Löschen">
          <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
      </form>
      </li>
      <?php else: ?>
      <li><a href="<?=$hpath?>php/anmeldung/anmeldung.php">Anmelden</a></li>
      <li><a href="<?=$hpath?>php/registrieren/registrieren.php">Registrieren</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
 
<?php
  if(isset($_GET["cause"])):
?>
  <div class="errorpopup" id="errorpopup">
    <a id="errorbox"><noscript><?php echo urldecode($_GET["cause"]); ?></noscript></a>
  </div>
<?php
  endif;
?>

<script src="<?=$hpath?>javascript/error_popup.js"></script>

<?php
  if(isset($_POST["deleteUser"]) && validCSRF($_POST)): //validCSRF is not that necessary here since the user needs to confirm another time, but I want to prevent the user from clicking delete because they are confused how they landed here after getting cross site redirected
?>
<a>Möchtest du deinen Account und alle deine Beiträge/Kommentare wirklich löschen?</a>
<form action="<?=$hpath?>php/script_dropUser.php" method="post">
  <input type="submit" class="navdelete" value="Nutzer Löschen">
  <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
</form>
<?php
  endif;
?>