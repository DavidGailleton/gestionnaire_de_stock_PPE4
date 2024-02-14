<?php
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

session_start();

require 'database.php';

header("Location: ./app/controllers/Main.php");

?>