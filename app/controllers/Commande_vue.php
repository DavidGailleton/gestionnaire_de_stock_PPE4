<?php

namespace ppe4;

use ppe4\Controller;

class Commande_vue extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/commande_vue.php';
    }

}