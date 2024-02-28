<?php

namespace ppe4\controllers;

class Error
{

    /**
     * Affiche la page d'erreur lors d'un url invalide
     *
     * @return void
     */
    public function fausse_url(): void
    {
        require_once ROOT.'app/views/404.php';
    }
}