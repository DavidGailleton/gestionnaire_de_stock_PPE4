<?php
require_once ROOT.'app/models/Materiel.php';
function materiel_card(\ppe4\Materiel $materiel):string
{
    return '<div>' . $materiel->getLibelle(). $materiel->getDescription(). $materiel->getQteStock() .'</div>';
}