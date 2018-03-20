<?php
//require_once("MysqlDB.class.php");
require_once ('MySqlDAO.class.php');
require_once("conf.php");

class UserDAO extends MySqlDAO{
    public function __construct(){
    parent::__construct();
    }

    public function get($CS){
        $table = PILOTS_TABLE;
        $res = $this->execQuery( 'SELECT * FROM '.$table.' WHERE callsign = ?',array($CS));
        return $res;
    }



}
