<?php

namespace ppe4\controllers;
require_once ROOT.'app/controllers/Controller.php';
class Materiels extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/materiels.php';
    }
}