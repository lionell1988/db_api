<?php
$parameters = json_decode(file_get_contents("configs/conf.json"), true);
$dbParams = $parameters['DB_Par'];
$DBName = $dbParams['DBName'];
$host = $dbParams['host'];
$user = $dbParams['user'];
$pass = $dbParams['password'];

define("HOST_DB",$host);
define("USER_DB",$user);
define("PASS_DB",$pass);
define("NAME_DB",$DBName);
