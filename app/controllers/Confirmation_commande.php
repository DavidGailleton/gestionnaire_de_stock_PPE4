<?php

namespace ppe4;

use ppe4\Controller;

class Confirmation_commande extends Controller
{

    /**
     * Affiche la page confirmation_commande
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/confirmation_commande.php';
    }
}