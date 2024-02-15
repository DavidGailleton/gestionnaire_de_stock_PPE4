<?php

namespace ppe4;

require_once 'Login.php';
require_once 'Controller.php';

class Main extends Controller
{
    public function index():void
    {
        if (isset($_SESSION["user_mail"])){
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            //$login = new Login();
            //$login->login();

            header('Location: '.SERVER_URL.'?page=login');
            exit();
        }
    }




}
