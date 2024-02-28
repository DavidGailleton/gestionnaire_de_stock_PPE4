<?php

namespace ppe4\controllers;

class Liste_commande
{

    /**
     * Affiche la liste des commandes
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/liste_commande.php';
    }
}