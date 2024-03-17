<?php

namespace ppe4\controllers;

require_once "Login.php";
require_once "Controller.php";

class Main extends Controller
{
    public function index(): void
    {
        if (isset($_COOKIE["JWT"])) {
            $login = new Login();
            $login->verifier_validite_JWT();
        } else {
            $this->rediriger("login");
        }
    }
}
