<?php
    require_once("sql.php");

    //echo("123");

    $pid= $_POST['pid'];
    $password=$_POST['password'];

    $tid=1;
    
    $mysqli=(new DBConnetor())->getMysqli();

    $sql = "SELECT * FROM teams WHERE 
            ? = tid ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $tid);
    $stmt->execute();

    $result=$stmt->get_result();

    $row = $result->fetch_assoc();

    //echo("error");
    echo("{$row['level']}");

    

?>