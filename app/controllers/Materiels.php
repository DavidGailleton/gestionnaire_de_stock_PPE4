<?php

namespace ppe4;

class Materiels extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/materiels.php';
    }
}