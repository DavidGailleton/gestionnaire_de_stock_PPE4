<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Medicament;

require_once 'Controller.php';

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