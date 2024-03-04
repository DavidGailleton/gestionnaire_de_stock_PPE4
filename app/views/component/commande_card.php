<?php
function commande_card(int $id_commande, DateTime $date_commande, \ppe4\models\Statut $statut):void
{
    echo '
    <article class="card">
        <a href="index.php?pase=commande&id='.$id_commande.'">
            <h2>Commande n°'.$id_commande.'</h2>
            <p>Date de commande : '.$date_commande->format('d/m/Y').'</p>
            <p>Statut : '.$statut->value.'</p>
        </a>
    </article>
    ';
}
?>