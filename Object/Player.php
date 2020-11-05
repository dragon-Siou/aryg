<?php

    require_once("sql.php");

    class Player{

        public $account;
        public $password;
        public $name;
        public $tid;

        private $err;

        public function __construct()
        {
            $this->account="";
            $this->password="";
            $this->name="";
            $this->tid=null;
            $this->err="";
        }

        public function load($account, $password){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * FROM player WHERE 
            ? =  account";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $account);
            $stmt->execute();

            $result=$stmt->get_result();
            $mysqli->close();

            //沒讀到資料
            if($result->num_rows === 0){
                $this->err="帳號未建立";
                return false;
            }

            $row = $result->fetch_assoc();

            if($row["password"] !== $password){
                //echo("{$row['name']}  {$password}");
                $this->err="密碼錯誤";
                return false;
            }

            $this->account=$row["account"];
            $this->password=$row["password"];
            $this->name=$row["name"];
            $this->tid=$row["tid"];

            return true;
        }

        public function insert(){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "INSERT INTO player(account, password, name, tid)
            VALUES(?,?,?,?)";
            
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssi", 
                $this->account, $this->password, $this->name, $this->tid);
            $stmt->execute();

            if($stmt->affected_rows===1){
                return true;
            }
            else{
                $this->err="插入失敗";
                return false;
            }

        }

        public function getErr(){
            return $this->err;
        }

    }

/*
    $test=new Player();
    if($test->load("brian","12134")){
        echo("載入成功");
        echo(json_encode($test));
    }
    else{
        echo($test->getErr());
    }*/

    /*
    $insert=new Player();
    $insert->account="insert";
    $insert->password="55";
    $insert->name="aaaa";
    if($insert->insert()){
        echo("插入成功");
    }
    else{
        echo($insert->getErr());
    }*/


?>