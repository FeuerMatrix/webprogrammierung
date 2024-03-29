<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (isset($_GET["id"]) && is_string($_GET["id"]) && $_GET["id"]!=Null) {
    $id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
    $auth = isset($_SESSION["user"]);
    $accept_map = isset($_COOKIE["accept"]);


    $modifiesOld = isset($_GET["old"]);
    if ($modifiesOld) {
        $oldComment = $_GET["old"];
    }

    include_once $path."datenbank/SQLiteStore.php";
    $database = new SQLiteStore();

    if($auth) {
        $isAuthor = $_SESSION["user"] == htmlspecialchars_decode($database->getAuthor($id));
    }

    if (isset($_POST["Submit"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        if (htmlspecialchars_decode($database->getAuthor($id)) == $_SESSION["user"]) {
            header("Location: ".$hpath."php/beitragErstellen/eintragneu.php?from=" . $id);
        } else {
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Posts!"));
        }
        exit;
    }

    if (isset($_POST["delete"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        $database->beginTransaction();
        if (htmlspecialchars_decode($database->getAuthor($id)) == $_SESSION["user"]) {
            $database->deletePost($id);
            header("Location: ".$hpath."php/hauptseite/hauptseite.php?from=" . $id);
        } else {
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Posts!"));
        }
        exit;
    }


    if (isset($_POST["deleteComm"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
        $database->beginTransaction();
        if (htmlspecialchars_decode($database->getCommentAuthor($id, $comm_id)) == $_SESSION["user"]) {
            $database->deleteComm($id, $comm_id);
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id);
        } else {
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Kommentars!"));
        }
        exit;
    }


    if (isset($_POST["Edit"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
        if (htmlspecialchars_decode($database->getCommentAuthor($id, $comm_id)) == $_SESSION["user"]) {
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id . "&c_id=" . $comm_id . "&old=" . urlencode($database->getComment($id, $comm_id)));
        } else {
            header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Kommentars!"));
        }
        exit;
    }

    if (isset($_POST["new"]) && isset($_SESSION["user"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        if (!isset($_GET["old"])) {
            $database->newComment($_SESSION["user"], $new, $id);
        } else {
            $comm_id = $_GET["c_id"];
            $database->beginTransaction();
            if (htmlspecialchars_decode($database->getCommentAuthor($id, $comm_id)) == $_SESSION["user"]) {
                $database->updateComment($id, $comm_id, $new);
                header("Location: ".$hpath."php/beitrag/beitrag.php?id=" . $id);
                exit;
            }
            $database->endTransaction();
        }
    }

    $titel = $database->getTitel($id);
    $desc =  $database->getDesc($id);
    $author = $database->getAuthor($id);
    $date =  $database->getDate($id);

    $img =  $database->getImage($id);
    $hasImg = $img != "";
    if($hasImg) $img = $hpath.$img;

    $comments = $database->getComments($id);
    $anony = $database->getAnonym($id);
    
    $lat = $database->getlat($id);
    $lng = $database->getlng($id);
    if($lat==null){
        $lat = "'.'";
        $lng = "'.'";
    }
    
    function createComment($comm_id, $name, $text)
    {
        global $id;
        global $database;
        ?>
        <div class=commentbox>
            <p><?php echo $name ?></p>
            <p><?php echo $text ?></p>
            <form method="post">
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == htmlspecialchars_decode($database->getCommentAuthor($id, $comm_id))) : ?>
                    <input type="submit" name="Edit" value="Bearbeiten" class=edit>
                    <input type="submit" name="deleteComm" value="Löschen" class="delete">
                    <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
                <?php endif; ?>
                <input type="hidden" name="c_id" value=<?php echo $comm_id ?>>
            </form>

        </div>
<?php
    }
} else {
    header("Location: ".$hpath."php/hauptseite/hauptseite.php");
    exit;
}
?>