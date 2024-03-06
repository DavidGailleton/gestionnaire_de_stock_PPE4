<?php
require_once ROOT.'app/models/Utilisateur.php';
function utilisateur_card(\ppe4\models\Utilisateur $utilisateur):void
{
    echo '
    <article class="card">
        <div>
            test
        </div>
    </article>
    
    ';
}
