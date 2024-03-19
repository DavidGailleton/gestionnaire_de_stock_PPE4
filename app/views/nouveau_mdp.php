<?php
if (!isset($_SESSION['user_email']) || isset($_COOKIE['JWT'])){
    header('Location: index.php?page=login');
    exit();
}
require_once ROOT.'app/includes/config.php'
?>

<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php
require_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\controllers\JWT();
if (isset($_COOKIE['JWT']) && $jwt->verifier_validite($_COOKIE['JWT']))
{
    include_once ROOT.'app/views/component/header.php';
}
else echo '<div></div>'
?>
<main>
    <p id="message_d_erreur" style="display: none">Les nouveaux mdp fournie ne sont pas les mêmes</p>
    <form method="post" action="index.php?action=modifier_mdp" id="formulaire_nouveau_mdp" onsubmit="return verifier_mdp()">
        <label for="ancien_mot_de_passe">Ancien mot de passe :</label><br>
        <input type="password" id="ancien_mot_de_passe" name="ancien_mdp"><br>

        <label for="nouveau_mdp">Nouveau mot de passe :</label><br>
        <input type="password" id="nouveau_mdp" name="nouveau_mdp"><br>

        <label for="confirmation_nouveau_mdp">Confirmer nouveau mot de passe :</label><br>
        <input type="password" id="confirmation_nouveau_mdp" name="confirmation_nouveau_mdp"><br>

        <input type="submit">
        <script>
            function verifier_mdp() {
                const nouveau_mdp = document.getElementById('nouveau_mdp').value;
                const ancien_mdp = document.getElementById('ancien_mot_de_passe').value;
                const confirmation_nouveau_mdp = document.getElementById('confirmation_nouveau_mdp').value;

                if (!ancien_mot_de_passe_correct()){
                    alert("Le mot de passe original n'est pas correct");
                    return false
                } else if (nouveau_mdp !== confirmation_nouveau_mdp){
                    alert("Les nouveaux mdp fournie ne sont pas les mêmes");
                    return false
                } else if (nouveau_mdp === ancien_mdp){
                    alert("Le mot de passe original et l'ancien ne peuvent pas être les mêmes");
                    return false
                } else if (/\s/.test(nouveau_mdp)){
                    alert("Le mot de passe ne doit pas contenir d'espace")
                    return false
                } else if (!mot_de_passe_valide(nouveau_mdp)){
                    alert("Le mot de passe doit contenir :\n- Au minimum <?php echo CHAR_MIN ?> caractères\n- Au minimum <?php echo UPPER_MIN ?> majuscule\n- Au minimum <?php echo LOWER_MIN ?> minuscule\n- Au minimum <?php echo NUM_MIN ?> chiffre\n- Au minimum <?php echo SPE_CHAR_MIN ?> caractère spécial(#?!@%&-_.)")
                    return false
                }
                else
                {
                    return true
                }
            }
            function mot_de_passe_valide(mot_de_passe){
                if (mot_de_passe.length < <?php echo CHAR_MIN ?>) {
                    return false;
                } else if (!mot_de_passe.match(/[A-Z]/g) || mot_de_passe.match(/[A-Z]/g).length < <?php echo UPPER_MIN ?>) {
                    return false;
                } else if (!mot_de_passe.match(/[a-z]/g) || mot_de_passe.match(/[a-z]/g).length < <?php echo LOWER_MIN ?>) {
                    return false;
                } else if (!mot_de_passe.match(/[0-9]/g) || mot_de_passe.match(/[0-9]/g).length < <?php echo NUM_MIN ?>) {
                    return false;
                } else if (!mot_de_passe.match(/[#?!@%&\-_.]/g) || mot_de_passe.match(/[#?!@%&\-_.]/g).length < <?php echo SPE_CHAR_MIN ?>) {
                    return false;
                }
                return true;
            }
            function ancien_mot_de_passe_correct(){
                let form = document.getElementById("ancien_mot_de_passe");
                let formData = new FormData(form);
                fetch("index.php?action=verifier_ancien_mot_de_passe", {
                    method: "POST",
                    body: formData
                }) .then(response => response.text())
                    .then(data => {
                        return data === true;
                    });
            }
        </script>
    </form>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>