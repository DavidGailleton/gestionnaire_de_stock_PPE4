<?php
require_once ROOT.'app/models/Medicament.php';
function medic_card(\ppe4\Medicament $medicament):string
{
    return '<div>' . $medicament->getLibelle(). $medicament->getDescription(). $medicament->getQteStock() . $medicament->getForme() . $medicament->getCis() .'</div>';
}