<?php
    require_once("Object/Teams.php");
    require_once("Object/Player.php");

    $account= "brian"; //$_POST["account"];
    $password= "12345"; //$_POST["password"];
    
    $player=new Player();

    if($player->load($account,$password)){
        echo(json_encode($player));
    }
    else{
        echo($player->getErr());
    }
    
?>