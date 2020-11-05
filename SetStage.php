<?php
    require_once("Object/Teams.php");

    $tid=$_POST["tid"];
    $stage=$_POST["stage"];

    $team=new Teams();
    $team->tid=$tid;
    $team->stage=$stage;

    if($team->update($tid)){
        echo($team->stage);
    }
    else{
        echo("錯誤");
    }

?>