<?php

namespace ppe4;

require_once 'Controller.php';

class Medicaments extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/medicaments.php';
    }
}