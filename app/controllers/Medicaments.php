<?php

namespace ppe4;

require_once 'Controller.php';

class Medicaments extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/medicaments.php';
    }

    public function status_a_afficher(int $nb_stock):string
    {
        if ($nb_stock >= 50){
            return 'En stock';
        } elseif ($nb_stock == 0){
            return 'Hors stock';
        } else {
            return $nb_stock.' en stock';
        }
    }
}