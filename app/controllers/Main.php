<?php

namespace ppe4;

require_once 'Login.php';
require_once 'Controller.php';

class Main extends Controller
{
    public function index():void
    {
        if (isset($_COOKIE["JWT"])){
            $login = new Login();
            $login->verify();
        } else {
            $this->redirect('login');
            exit();
        }
    }




}
