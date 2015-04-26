<?php
define("BASE_URL", "http://www.myprograming.esy.es");

if (!isset($_SESSION))
	session_start();

require 'core/bootstrap.php';
require 'core/base.php';
require 'core/view.php';
require 'core/model_base.php';
$b = new Bootstrap(); 

?>
