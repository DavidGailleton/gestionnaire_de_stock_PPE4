<?php

use ppe4\models\Medicament;

require_once ROOT.'app/models/Materiel.php';
require_once ROOT.'app/controllers/Panier.php';
require_once ROOT.'app/controllers/Materiels.php';

function materiel_card_panier(\ppe4\models\Materiel $materiel, int $i, int $quantite):string
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
        <p class="description">'.
        $materiel->getDescription()
        .'</p>
        <form action="index.php?action=supprimer_du_panier" method="post" id="formulaire_'.$i.'">
            <div class="ajout_panier">
                <label>
                    <input type="number" min="1" value="'.$quantite.'" name="qte" class="numeric_ajout_panier">
                    <input type="hidden" name="id" value="'.$materiel->getId().'">
                </label>
                <input type="submit" value="Supprimer" class="bouton_ajout_panier">
            </div>
        </form>
    </div>
</article>
</div>
<script>
    document.getElementById("formulaire_'.$i.'").addEventListener("input", function(){
        let form = document.getElementById("formulaire_'.$i.'");
        let formData = new FormData(form);
        fetch("index.php?action=modifier_qte_produit_panier", {
            method: "POST",
            body: formData
        })
    });
</script>
    ';
}
