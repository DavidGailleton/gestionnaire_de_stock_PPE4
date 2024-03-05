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

        <form action="index.php?action=ajouter_au_panier" method="post" id="formulaire_'.$i.'">
            <div class="ajout_panier">
                <label>
                    <input type="number" min="1" value="1" name="qte" class="numeric_ajout_panier">
                    <input type="hidden" name="id" value="'.$materiel->getId().'">
                </label>
                <input type="submit" value="Ajouter au panier" class="bouton_ajout_panier">
            </div>
        </form>
    </div>
    </article>
</div>';


}
?>


