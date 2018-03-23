<?php
require_once 'conf.php';
require_once 'Message.class.php';
class MySqlDAO {

    public function __construct(){
    }

    protected function execQuery($sql, $params = array()){
      //echo $sql;
  		$rv = array();
      $msg = new stdClass();
      $msg->code = 400;
      $msg->txt = 'bad request';
      $msg->res = $rv;
      @$connection = new mysqli(HOST_DB,USER_DB,PASS_DB,NAME_DB);
      if ($connection->connect_errno) {
        $code = $connection->connect_errno;
        //$txt = $connection->connect_error;
        $txt = 'Failed to connect to MySQL Server';
        $msg->code = $code;
        $msg->txt = $txt;
        return json_encode((array)$msg);
      }
  		if (count($params) > 0) {
            //      printf("preparando la query %s\n",$sql);
            $p = $connection->prepare($sql);
      			$types = $this->paramsTypes($params);
      			$p->bind_param($types, ...$params);
            if ($p->errno > 0) {
              $code = $p->errno;
              $txt = $p->error;
              @$connection->close();
              return new Message($code,$txt);
            }
      			$p->execute();
            if(!$p->execute()){
              if ($p->errno > 0){
                $code = $p->errno;
                $txt = $p->error;
                @$connection->close();
                return new Message($code,$txt);
              }
            }
            $rs = $p->get_result();
            $rv = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();
            $p->close();
  		}
      else {
	       $connection->query($sql);
		  }
      $connection->close();
      $msg->code = 200;
      $msg->txt = 'Ok';
      $msg->res = $rv;
  		return json_encode((array)$msg);
    }

    public function execInsert($sql, $params = array()){
        $code = 200; //OK
        $txt = 'Ok';
        $msg = new Message($code,$txt);
        @$connection = new mysqli(HOST_DB,USER_DB,PASS_DB,NAME_DB);
        if ($connection->connect_errno) {
          $code = $connection->connect_errno;
          //$txt = $connection->connect_error;
          $txt = 'Failed to connect to MySQL Server';
          return new Message($code,$txt);
        }
        if($p  = $connection->prepare($sql)){
          $types = $this->paramsTypes($params);

          $p->bind_param($types, ...$params);
          if ($p->errno > 0) {
              $code = $p->errno;
              $txt = $p->error;
              @$connection->close();
              return new Message($code,$txt);
          }
          if(!$p->execute()){
            if ($p->errno > 0){
              $code = $p->errno;
              $txt = $p->error;
              @$connection->close();
              return new Message($code,$txt);
            }
          }
          @$p->close();
          @$connection->close();
          return $msg;
      }else{
        @$connection->close();
        return new Message(400,'bad request');
      }

    }

    private function paramsTypes($params) {
    		$types = '';
    		foreach ($params as $param) {
          if($param == null){
              $types .= 's';
          }
    			if (is_int($param)) {$types .= 'i';
    			}

    			if (is_double($param)) {$types .= 'd';
    			}

    			if (is_string($param)) {$types .= 's';
    			}

    		}

    		return $types;
    }

}
