<?php
//require_once("MysqlDB.class.php");
require_once ('MySqlDAO.class.php');
require_once("conf.php");

class ObjDAO extends MySqlDAO{
    public function __construct(){
    parent::__construct();
    }

    public function get($table,$field, $val){
        $res = $this->execQuery( 'SELECT * FROM '.$table.' WHERE '.$field.' = ?',array($val));
        return $res;
    }

    public function save($table, $obj){
        //echo $table;
        $v = array_values((array)$obj);
        $keys = array_keys((array)$obj);
        $n_fields = count($v);
        //echo $n_fields;
        $sql = 'INSERT INTO '.$table.' ';
        $sql = $sql.'(';
      //  echo $sql;
        for($i=0; $i < $n_fields; $i++){
          $sql = $i==$n_fields-1?$sql.$keys[$i]:$sql.$keys[$i].',';
        }
        $sql = $sql.') ';
        $sql = $sql.'VALUES (';
        for($i=0; $i < $n_fields; $i++){
          $sql = $i==$n_fields-1?$sql.'?':$sql.'?,';
        }
        $sql = $sql.')';
        //echo $sql;
        return $this->execInsert($sql,$v);
        //echo $v[0];
        /*
        foreach ($v as $value) {
          echo $value;
        }
        */

    }

    function edit($table, $id, $obj){
      $v = array_values((array)$obj);
      $keys = array_keys((array)$obj);
      $n_fields = count($v);
      $sql = "UPDATE $table SET ";
      for($i=0; $i < $n_fields; $i++){
        $sql = $i==$n_fields-1?$sql.$keys[$i].'="'.$v[$i].'"':$sql.$keys[$i].'=""'.$v[$i].'",';
      }
      $sql = $sql.' WHERE id = '.$id;
      return $this->execQuery($sql);
    }



}
