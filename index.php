<?php
session_start();

require 'database.php';

if (isset($_SESSION["user_id"])){
    header("Location: ./views/dashboard.php");
    exit();
} else {
    header("Location: ./views/login.php");
}
?>