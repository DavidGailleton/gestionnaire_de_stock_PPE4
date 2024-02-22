<?php
require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Medicaments.php';
function medic_card(\ppe4\Medicament $medicament):string
{
    //return ('<div>' . $medicament->getLibelle(). $medicament->getDescription(). $medicament->getQteStock() . $medicament->getForme() . $medicament->getCis() .'</div>');
    $medicaments = new \ppe4\Medicaments();


    $html = '<a href="" class="product_card">
    <article class="">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().' - CIS : '. $medicament->getCis() .'</h3>
        </div>
        <p>'.$medicament->getForme().'</p>
    </div>
    <div class="bas">
        <p class="description">'.
            $medicament->getDescription()
        .'</p>
        <div class="status">
            '.$medicaments->status_a_afficher($medicament->getQteStock()).'
        </div>
    </div>
</article>
</a>
    ';
    return $html;
}
?>