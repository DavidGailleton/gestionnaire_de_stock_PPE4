<?php
require_once ROOT.'app/models/Materiel.php';
require_once ROOT.'app/controllers/Materiels.php';
function materiel_card_commande_vue(\ppe4\models\Materiel $materiel, int $i):string
{
    return '<div class="card">
    <article class="materiel_card">
    <div class="haut">
        <h3>' .$materiel->getLibelle().'</h3>
        <div class="status">
            '.$i.'
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


