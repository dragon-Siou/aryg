<?php

    require_once("sql.php");

    class Teacher{
        public $tcid;
        public $password;
        public $name;
        private $err;
        
        public function __construct()
        {
            $this->tcid=null;
            $this->password="";
            $this->name="";
            $this->err="";
        }

        public function load($tcid, $password){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * FROM teacher WHERE 
            ? =  tcid";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $tcid);
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

            $this->tcid=$row["tcid"];
            $this->password=$row["password"];
            $this->name=$row["name"];

            return true;


        }

        public function insert(){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "INSERT INTO teacher(tcid, password, name)
            VALUES(?,?,?)";
            
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss", 
                $this->tcid, $this->password, $this->name);
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
    $test=new Teacher();
    if($test->load("brian","12134")){
        echo("載入成功");
        echo(json_encode($test));
    }
    else{
        echo($test->getErr());
    }

    $test=new Teacher();
    $test->tcid="xxx";
    $test->password="2222";
    $test->name="eee";
    if($test->insert()){
        echo(json_encode($test));
    }
    else{
        echo($test->getErr());
    }
*/

?>