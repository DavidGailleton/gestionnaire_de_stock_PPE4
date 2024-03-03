<?php
require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Medicaments.php';
function medic_card_commande_vue(\ppe4\models\Medicament $medicament, int $i):string
{
    $medicaments = new \ppe4\controllers\Medicaments();


    return '<div class="card">
    <article class="medic_card">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().'</h3>
            <h4>  - CIS : '. $medicament->getCis() .'</h4>
        </div>
        <div class="status">
            '.$medicaments->status_a_afficher($medicament->getQteStock()).'
        </div>
    </div>
    <div class="bas">
        <p class="description">'.
        $medicament->getDescription()
        .'</p>
        <div>
            
        </div>
    </div>
</article>
</div>
    ';
}
?>
