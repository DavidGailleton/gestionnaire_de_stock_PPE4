<?php

namespace ppe4;

use ppe4\Controller;

class Page_produit extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/page_produit.php';
    }
}