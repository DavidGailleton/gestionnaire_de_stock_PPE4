<?php

use ppe4\models\Medicament;

require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Panier.php';
function medic_card_panier(Medicament $medicament, int $i, int $qte):string
{
    $medicaments = new \ppe4\controllers\Medicaments();


    return '<div class="medic_card">
    <article class="">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().'</h3>
            <br>
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
        <form action="index.php?action=supprimer_du_panier" method="post" id="formulaire_'.$i.'">
            <div class="ajout_panier">
                <label>
                    <input type="number" min="1" value="'.$qte.'" name="qte" class="numeric_ajout_panier">
                </label>
                <input type="submit" value="Supprimer" class="bouton_ajout_panier">
            </div>
        </form>
    </div>
</article>
<script >
    window.onload = function() {
      document.getElementById("formulaire_'.$i.'").addEventListener("submit", function(){
          let champCache = document.createElement("input")
          champCache.type = "hidden";
          champCache.name = "id";
          champCache.value = '.$medicament->getId().'
          this.appendChild(champCache)
      });
    }
</script>
</div>
    ';
}
?>