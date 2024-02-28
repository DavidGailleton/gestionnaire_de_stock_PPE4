<?php
require_once ROOT.'app/models/Materiel.php';
function materiel_card(\ppe4\models\Materiel $materiel, int $i):string
{
    return '<article>
    <div>
        <h3>'.$materiel->getLibelle().'</h3>
        <div>
            <p>'.$materiel->getQteStock().'</p>
        </div>
    </div>
    <div>
        <p>'.$materiel->getDescription().'</p>

        <form action="'.SERVER_URL."index.php?action=ajouter_au_panier_materiel".'" method="post" id="formulaire_'.$i.'">
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
          champCache.value = '.$materiel->getId().'
          this.appendChild(champCache)
      });
    }
</script>';


}
?>


