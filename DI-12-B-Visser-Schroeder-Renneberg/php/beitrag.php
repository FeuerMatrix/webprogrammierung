<?php
$id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
$auth = isset($_SESSION["user"]);

include_once "datenbank/DummyUserStore.php";
$database = new DummyUserStore();

if(isset($_POST["Submit"])){
    //TODO check if owner
    $_SESSION["id"]=$id;
    header("Location: eintragneu.php?from=Beitrag");
    exit;
    }

$edit = false;

if(isset($_POST["Edit"])){
    //TODO check if owner
    $edit = true;
    $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
    $old = $database->getComment($id,$comm_id);
}   

if(isset($_POST["new"]) && isset($auth)){
    if(!$edit){
    $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
    $database->newComment($auth,$new);
    }else{
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        $database->updateComment($id,$comm_id,$new);
        $edit=false;
    }
}   

$titel = $database->getTitel($id);
$desc =  $database->getDesc($id);
$author = $database->getAuthor($id);
$date =  $database->getDate($id);
$img =  $database->getImage($id);
$comments = $database->getComments($id);


function createComment($id, $name, $text)
{
?>
    <div class=commentbox>
        <p><?php echo $name ?></p>
        <p><?php echo $text ?></p>
        <form method="post">
            <input type="submit" name="Edit" value="Bearbeiten" class=edit>
            <input type="hidden"  name="c_id" value=<?php echo $id ?>>
        </form>

    </div>
<?php
}
?>