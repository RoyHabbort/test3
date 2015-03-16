<?php

header('Content-Type: text/html; charset=utf8');

//Подключение классов
heretic::connect('configuration/', 'Config.php');
heretic::connectDir('class/', heretic::$_kernel, 'Class.php');
heretic::connect(heretic::$_path['models'], '.php');

session_start();

$router = new routerClass();
$router->delegate();

?>

