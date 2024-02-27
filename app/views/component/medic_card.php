<?php
require_once ROOT.'app/models/Medicament.php';
require_once ROOT.'app/controllers/Medicaments.php';
function medic_card(\ppe4\Medicament $medicament, int $i):string
{
    //return ('<div>' . $medicament->getLibelle(). $medicament->getDescription(). $medicament->getQteStock() . $medicament->getForme() . $medicament->getCis() .'</div>');
    $medicaments = new \ppe4\Medicaments();


    return '<div href="" class="product_card">
    <article class="">
    <div class="haut">
        <div>
            <h3>' . $medicament->getLibelle().'</h3>
            <br>
            <h4>  - CIS : '. $medicament->getCis() .'</h4>
        </div>
        ' /* <p>'.$medicament->getForme().'</p> */
        .'
        <div class="status">
            '.$medicaments->status_a_afficher($medicament->getQteStock()).'
        </div>
    </div>
    <div class="bas">
        <p class="description">'.
            $medicament->getDescription()
        .'</p>
        <form action="'.SERVER_URL."index.php?action=ajouter_au_panier_medicament".'" method="post" id="formulaire_'.$i.'">
            <div>
                <label>
                    <input type="number" min="1" value="1" name="qte">
                </label>
                <input type="submit" value="Ajouter au panier" class="bouton_ajout_panier">
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


