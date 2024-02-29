<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Materiel;

class Page_produit extends Controller
{

    public function index():void
    {
        require_once ROOT.'app/views/page_produit.php';
    }
}