<?php

namespace ppe4\controllers;

use ppe4\models\Commande;

require_once ROOT.'app/controllers/Controller.php';

class Commande_vue extends Controller
{
    public function afficher(int $id_commande):void
    {
        require_once ROOT.'app/views/commande_vue.php';
    }
}