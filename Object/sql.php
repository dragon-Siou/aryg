<?php

    class DBConnetor{
        private $mysqli;

        public function __construct(){
            $this->mysqli = new mysqli("127.0.0.1","root","");
            $this->mysqli->select_db("aryg");
            if($this->mysqli->connect_errno){
                exit("無法連線資料庫伺服器");
                //echo("連線失敗");
                //echo("連線成功!");
            }
            $this->mysqli->set_charset("utf8");
        }



        public function getMysqli(){
            return $this->mysqli;
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
    
?>