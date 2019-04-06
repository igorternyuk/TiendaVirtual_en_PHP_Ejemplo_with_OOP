<?php
session_start(); //starts the session
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once (ROOT."/config/config.php");
require_once (ROOT."/components/Autoload.php");

$router = new Router();
$router->run();