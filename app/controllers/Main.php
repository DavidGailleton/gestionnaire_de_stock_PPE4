<?php
require "../models/Model.php";

if (isset($_SESSION["user_mail"])){
    header("Location: ../views/dashboard.php");
    exit();
} else {
    header("Location: Login.php");
}