<?php
require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Panier.php';
function medic_card_panier(\ppe4\Medicament $medicament, int $i):string
{
    $panier = new \ppe4\Panier();

    return '<a href="" class="product_card">
    <article class="">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().' - CIS : '. $medicament->getCis() .'</h3>
        </div>
        <p>'.$medicament->getForme().'</p>
        <div class="status">
            '.$panier->status_a_afficher($medicament->getQteStock()).'
        </div>
    </div>
    <div class="bas">
        <p class="description">'.
        $medicament->getDescription()
        .'</p>
        <form action='.SERVER_URL."index.php?action=ajouter_au_panier_medicament".' method="post" id="formulaire_'.$i.'">
            <div>
                <label>
                    <input type="number" min="1" value="1">
                </label>
                <input type="submit" value="Ajouter au panier" class="bouton_ajout_panier">
            </div>
        </form>
    </div>
</article>
<script >
    window.onload = function() {
      document.getElementById("formulaire_'.$i.'").addEventListener("submit", function()){
          let champCache = document.createElement("input")
          champCache.type = "hidden";
          champCache.name = "id";
          champCache.value = '.$medicament->getId().'
          this.appendChild(champCache)
      }
    }
</script>
</a>
    ';
}
?>