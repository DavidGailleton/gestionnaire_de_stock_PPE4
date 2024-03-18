<?php
require_once ROOT.'app/models/Utilisateur.php';
require_once ROOT.'app/controllers/Profile_vue_admin.php';
$profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();

if (isset($_POST['id_utilisateur'])){
    $utilisateur = $profile_vue_admin->selectionner_utilisateur($_POST['id_utilisateur']);
}

?>
<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    if (isset($_POST['id_utilisateur']) && $utilisateur){
        echo '
        <form class="form_profile_vue_admin" method="post" action="index.php?action=modifier_utilisateur">
            <div>
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <p>Email</p>
                <label>
                    <input type="email" name="email" value="'.$utilisateur->getEmail().'">
                </label>
            </div>
            <div>
                <p>Prenom</p>
                <label>
                    <input type="text" name="prenom" value="'.$utilisateur->getPrenom().'">
                </label>
            </div>
            <div>
                <p>Nom de famille</p>
                <label>
                    <input type="text" name="nom" value="'.$utilisateur->getNom().'">
                </label>
            </div>
            <div>
                <p>Role</p>
                <label>
                    <select name="libelle_role">
                        '.$profile_vue_admin->afficher_option_role($utilisateur->getRole()->getLibelle()).'
                    </select>
                </label>
            </div>
            <button type="submit">Modifier l\'utilisateur</button>
        </form>
            <form action="index.php?action=supprimer_utilisateur" method="post">
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <button id="boutton_supprimer" type="submit" onclick="return confirmer_suppression()">Supprimer l\'utilisateur</button>
            </form>';
        if ($utilisateur->isCompteDesactive()){
            echo '<form action="index.php?action=activer_utilisateur" method="post">
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <button id="boutton_activer" type="submit">Activer l\'utilisateur</button>
            </form>';
        } else {
            echo '<form action="index.php?action=desactiver_utiliasteur" method="post">
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <button id="boutton_desactiver" type="submit">Désactiver l\'utilisateur</button>
            </form>';
        }


        echo    '
            <form action="index.php?action=reinitialiser_mot_de_passe" method="post">
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <input name="mdp_a_changer" id="mdp_a_changer" type="text" value="" style="display: none">
                <button id="boutton_reinitialiser_mot_de_passe" type="submit" onclick="return reinitialiser_mot_de_passe()">Reinitialiser mot de passe</button>
            </form>
        ';
    } else {
        echo '
            <h1>Une erreur s\'est produite</h1>
        ';
    }
    ?>
    <script>
        function confirmer_suppression() {
            let confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");

            if (confirmation) {
                console.log("L'utilisateur a confirmé l'action.");
                return true;
            } else {
                console.log("L'utilisateur a annulé l'action.");
                return false;
            }
        }

        function reinitialiser_mot_de_passe(){
            let mot_de_passe = prompt("Veuillez entrer le nouveau mot de passe pour cet utilisateur");

            if (mot_de_passe.trim() !== null || ""){
                console.log("L'utilisateur a confirmé l'action.");
                document.getElementById("mdp_a_changer").value = mot_de_passe;
                return true;
            } else {
                console.log("L'utilisateur a annulé l'action.");
                return false;
            }
        }
    </script>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>