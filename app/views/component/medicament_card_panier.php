<?php

use ppe4\models\Medicament;

require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Panier.php';
require_once ROOT.'app/controllers/Medicaments.php';

function medic_card_panier(Medicament $medicament, int $i, int $quantite):string
{
    $medicaments = new \ppe4\controllers\Medicaments();


    return '<div class="card">
    <article class="medic_card">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().'</h3>
            <br>
            <h4>  - CIS : '. $medicament->getCis() .'</h4>
        </div>
        <div class="status">
            '.$medicaments->status_a_afficher($medicament->getQuantiteStock()).'
        </div>
    </div>
    <div class="bas">
        <p class="description">'.
        $medicament->getDescription()
        .'</p>
        <form action="index.php?action=supprimer_du_panier" method="post" id="formulaire_'.$i.'">
            <div class="ajout_panier">
                <label>
                    <input type="number" min="1" value="'.$quantite.'" name="qte" class="numeric_ajout_panier">
                    <input type="hidden" name="id" value="'.$medicament->getId().'">
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
?>