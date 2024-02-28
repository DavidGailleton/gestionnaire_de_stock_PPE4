<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Commande_vue extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/commande_vue.php';
    }

}