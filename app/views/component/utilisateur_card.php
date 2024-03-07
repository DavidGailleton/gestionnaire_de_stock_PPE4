<?php
require_once ROOT.'app/models/Utilisateur.php';
function utilisateur_card(\ppe4\models\Utilisateur $utilisateur):void
{
    if ($utilisateur->isCompteDesactive()){
        $etat_compte = "Compte désactivé";
    } else {
        $etat_compte = "Compte activé";
    }

    echo '
    <article class="card">
        <div>
            <div>
                <p>'.$utilisateur->getNom().' '.$utilisateur->getPrenom().'</p>
                <br>
                <p>'.$utilisateur->getEmail().'</p> 
            </div>
            <div>
                <p>'.$utilisateur->getRole()->getLibelle().'</p>
            </div>
            
        </div>
        <div>
            <div>
                <p>'.$etat_compte.'</p>
            </div>
        </div>
    </article>
    
    ';
}
