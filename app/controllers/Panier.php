<?php

namespace ppe4;

use ppe4\Controller;

class Panier extends Controller
{

    /**
     * Affiche la page du panier
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/panier.php';
    }
}