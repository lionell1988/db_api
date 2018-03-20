<?php
/**
  ROUTING
**/
$method = $_SERVER['REQUEST_METHOD'];
require_once 'classes/Message.class.php';
//echo $method;
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

    if(count($nroutes) == 0){
      header('Content-Type: application/json');
      $msg = new Message('400','bad request');
      echo $msg->toJSON();
      exit();
    }

    switch ($method) {
        case 'GET': //SELECT (by id)
            header('Content-Type: application/json');
            $msg = new Message('400','bad request');
            require_once 'classes/ObjDAO.class.php';
            $table = $nroutes[0];
            try{
              $id = $nroutes[1];
              echo select($table, $id);

            }catch(Exception $e){
                echo $msg->toJSON();
            }
            break;
        case 'POST': //INSERT
            header('Content-Type: application/json');
            $table = $nroutes[0];
            echo json_encode(insert($table));
            break;
        default:
            header('Content-Type: application/json');
            $msg = new Message('400','bad request');
            echo $msg->toJSON();
            break;
    }

    function select($table, $id){
          $objDao = new ObjDAO();
          return $objDao->get($table, $id);
    }

    function insert($table){
      $status = 400;
      require_once 'classes/ObjDAO.class.php';
      require_once 'classes/User.class.php';
      //oggetto di esempio
      //$obj = array('name'=>'leonardo','surname'=>'avena','username'=>'lionell888','email'=>'leo@email.fra','token'=>' ','password'=>'111213');
      //$objDao = new ObjDAO();
      //$status = $objDao->save($table,$obj);
      if(count($_POST)>0){
          $objDao = new ObjDAO();
          $status = $objDao->save($table,$_POST);
      }
      return $status;
    }
