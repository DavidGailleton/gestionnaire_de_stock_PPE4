<?php

namespace ppe4;

use ppe4\Controller;

class Panier extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/panier.php';
    }
}