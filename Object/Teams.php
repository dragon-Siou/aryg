<?php

    require_once("sql.php");

    class Teams{
        
        public $tid;
        public $tName;
        public $stage;

        private $err;

        public function __construct()
        {
            $this->tid=null;
            $this->tName="";
            $this->stage=null;
            $this->err="";
        }

        public function load($tid){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * FROM teams WHERE 
            ? =  tid";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $tid);
            $stmt->execute();

            $result=$stmt->get_result();
            $mysqli->close();

            //沒讀到資料
            if($result->num_rows === 0){
                $this->err="隊伍未建立";
                return false;
            }

            $row = $result->fetch_assoc();

            $this->tid=$tid;
            $this->tName=$row["tName"];
            $this->stage=$row["stage"];

            return true;
        }

        public function insert(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="INSERT INTO teams(tName)
            VALUES(?)";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", 
                $this->tName);
            $stmt->execute();

            if($stmt->affected_rows===1){
                return true;
            }
            else{
                $this->err="插入失敗";
                return false;
            }
        }

        public function update(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="UPDATE teams SET stage=? WHERE tid=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", 
                $this->stage, $this->tid);
            $stmt->execute();

            if($stmt->affected_rows===1){
                return true;
            }
            else{
                $this->err="更新失敗";
                return false;
            }
        }

        public function getErr(){
            return $this->err;
        }
    }


/*
    $load=new Teams();
    if($load->load(1)){
        echo(json_encode($load));
    }
    else{
        echo($load->getErr());
    }

    $insert=new Teams();
    $insert->tName="c";
    if($insert->insert()){
        echo("差入成功");
    }
    else{
        echo("插入失敗");
    }*/

?>