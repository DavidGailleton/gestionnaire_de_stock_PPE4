<?php
require_once ROOT.'app/models/Materiel.php';
require_once ROOT.'app/controllers/Materiels.php';
function materiel_card(\ppe4\models\Materiel $materiel, int $i):string
{
    $materiels = new \ppe4\controllers\Materiels();

    return '<div class="card">
    <article class="materiel_card">
    <div class="haut">
        <h3>' .$materiel->getLibelle().'</h3>
        <div class="status">
            '.$materiels->status_a_afficher($materiel->getQuantiteStock()).'
        </div>
    </div>
    <div class="bas">
        <p class="description">'.$materiel->getDescription().'</p>

        <div>
            
        </div>
    </div>
    </article>
</div>';


}
?>


