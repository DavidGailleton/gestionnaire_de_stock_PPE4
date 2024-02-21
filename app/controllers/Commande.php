<?php

namespace ppe4;

use ppe4\Controller;

class Commande extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/commande.php';
    }

}