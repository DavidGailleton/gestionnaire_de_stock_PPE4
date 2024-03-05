<?php
function commande_card(int $id_commande, DateTime $date_commande, \ppe4\models\Statut $statut):void
{
    echo '
    <article class="card">
        <form action="index.php?page=commande" method="POST" id="formCommande'.$id_commande.'">
            <input type="number" style="display: none;" name="id_commande" value="'.$id_commande.'">
        </form>
        <a href="#" onclick="document.getElementById(\'formCommande'.$id_commande.'\').submit();">
            <h2>Commande n°'.$id_commande.'</h2>
            <p>Date de commande : '.$date_commande->format('d/m/Y').'</p>
            <p>Statut : '.$statut->value.'</p>
        </a>
    </article>
    ';
}
?>