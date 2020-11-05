<?php

    require_once("sql.php");

    class Teams{
        
        public $tid;
        public $tName;
        public $tcid;
        public $stage;
        public $startTime;
        public $endTime;

        private $err;

        public function __construct()
        {
            $this->tid=null;
            $this->tName="";
            $this->tcid=null;
            $this->stage=null;
            $this->startTime=null;
            $this->endTime=null;
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
            $this->startTime=$row["startTime"];
            $this->endTime=$row["endTime"];

            return true;
        }

        public function insert(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="INSERT INTO teams(tName, tcid)
            VALUES(?,?)";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", 
                $this->tName, $this->tcid);
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

        public function isReady(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT count(*) as count FROM player WHERE tid=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", 
                $this->tid);
            $stmt->execute();

            $totalPlayer=$stmt->get_result()->fetch_assoc()["count"];

            $sql="SELECT count(*) as count FROM player WHERE tid=6 and isReady = 'y'";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            $isReadyPlayer=$stmt->get_result()->fetch_assoc()["count"];

            if($totalPlayer === $isReadyPlayer){
                return true;
            }
            else{
                return false;
            }


        }

        public function SetStartTime(){
            $time=date('Y-m-d H:i:s', time());

            $mysqli=(new DBConnetor())->getMysqli();
            $sql="UPDATE teams SET startTime = '{$time}' WHERE tid=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", 
                $this->tid);
            $stmt->execute();

            if($stmt->affected_rows === 1){
                $this->startTime= "{$time}";
                return true;
            }
            else{
                $this->err="設定開始時間錯誤";
                return false;
            }

        }

        public function SetEndTime(){
            $time=date('Y-m-d H:i:s', time());

            $mysqli=(new DBConnetor())->getMysqli();
            $sql="UPDATE teams SET endTime = '{$time}' WHERE tid=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", 
                $this->tid);
            $stmt->execute();

            if($stmt->affected_rows === 1){
                $this->startTime= "{$time}";
                return true;
            }
            else{
                $this->err="設定結束時間錯誤";
                return false;
            }
        }
    }


/*
    $load=new Teams();
    if($load->load(6)){
        if($load->SetEndTime()){
            echo(json_encode($load));
        }
        else{
            echo($load->getErr());
        }
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
    }

    $load=new Teams();
    if($load->load(6)){
        if($load->isReady()){
            echo("是");
        }
        else{
            echo("不是");
        }
        
    }
    else{
        echo($load->getErr());
    }*/



?>