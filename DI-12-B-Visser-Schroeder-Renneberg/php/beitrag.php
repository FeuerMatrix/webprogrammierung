<?php

$id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
$auth = isset($_SESSION["user"]);

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
}   

if(isset($_POST["new"]) && isset($auth)){
    if($edit){
    $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
    //save to db $new $auth
    //add id in db
    }else{
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        //update $comm_id  $new $auth
    }
}   

//TODO get from DB
$titel = "Testtitel";
$desc = "Testdesc";
$author = "Ich";
$date ="1.1.1970";
$img = "images/guestbook.png";
$comments = array(
    array(0, "Der","grfaghaergherreag"),
    array(1, "Die","harhngrjrtahgrfsjhtr"),
    array(2, "Das","htrshtgbgsfhjtrsh")
);


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