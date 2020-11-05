<?php
    require_once("Object/Teams.php");

    $tid=$_POST["tid"];

    $team=new Teams();
    if($team->load($tid)){
        echo($team->stage);
    }
    else{
        echo("錯誤");
    }

?>