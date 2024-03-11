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
        <div class="utilisateur_card">
            <a href="#" onclick="document.getElementById(\'form_'.$utilisateur->getId().'\').submit();">
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
            </a>
            
            <form action="index.php?page=profile_vue_admin" method="post" id="form_'.$utilisateur->getId().'" style="display: none;">
                <input type="number" name="id_utilisateur" value="'.$utilisateur->getId().'">
            </form>
        </div>
    </article>
    ';
}
