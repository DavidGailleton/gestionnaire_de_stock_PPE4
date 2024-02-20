<?php

namespace ppe4;

use ppe4\Controller;

class Gestion_utilisateurs extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/gestion_utilisateurs.php';
    }
}