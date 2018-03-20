<?php
/**
  ROUTING
**/

function getCurrentUri()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        //echo $basepath;
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = '/' . trim($uri, '/');
        return $uri;
    }

    $base_url = getCurrentUri();
    $routes = array();
    $routes = explode('/', $base_url);

    $nroutes = array();

    foreach($routes as $route)
    {
      //  echo "<p>$route</p>";
        if(trim($route) != '')
            array_push($nroutes, $route);
    }



    switch ($nroutes[0]) {
      //INSERT API
      case 'insert':
        header('Content-Type: application/json;charset=utf-8');
        if($nroutes[1] != null || $nroutes[1] != ''){
          $msg = insert($nroutes[1]);
          /*
          $txt = $code==200?'Ok':'error';
          $msg = new Message($code,$txt);
          */
        }
        else{
          $msg = new Message('400','bad request');
        }
        echo $msg->toJSON();
        break;

      default:
        header('Content-Type: application/json');
        $msg = new Message('400','bad request');
        break;
    }


    function insert($table){
      $status = 400;
      require_once 'classes/Message.class.php';
      require_once 'classes/ObjDAO.class.php';
      require_once 'classes/User.class.php';
      //oggetto di esempio
      $obj = array('name'=>'leonardo','surname'=>'avena','username'=>'lionell888','email'=>'leo@email.fra','token'=>' ','password'=>'111213');
      $objDao = new ObjDAO();
      $status = $objDao->save($table,$obj);
      if(count($_POST)>0){
          $objDao = new ObjDAO();
          $status = $objDao->save($table,$_POST);
      }
      return $status;
    }
