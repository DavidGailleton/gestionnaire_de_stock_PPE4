<?php
if (!$_SESSION['user_email'] && !isset($_COOKIE['JWT'])){
    header('Location: '.SERVER_URL.'index.php?page=login');
}
?>

<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php
require_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\JWT();
if (isset($_COOKIE['JWT']) && $jwt->check($_COOKIE['JWT']))
{
    include_once ROOT.'app/views/component/header.php';
}
?>
<main>
    <p id="message_d_erreur" style="display: none">Les nouveaux mdp fournie ne sont pas les mêmes</p>
    <form method="post" action="<?php echo SERVER_URL."index.php?action=modifier_mdp" ?>" id="formulaire_nouveau_mdp" onsubmit="return verifier_mdp()">
        <label>
            <input type="password" id="ancien_mdp" name="ancien_mdp">
        </label>
        <label>
            <input type="password" id="nouveau_mdp" name="nouveau_mdp">
        </label>
        <label>
            <input type="password" id="confirmation_nouveau_mdp" name="confirmation_nouveau_mdp">
        </label>
        <input type="submit">
        <script>
            function verifier_mdp() {
                    if (document.getElementById('nouveau_mdp').values() === document.getElementById('confirmation_nouveau_mdp').values()){
                        return true
                    } else if (document.getElementById('nouveau_mdp').values() === document.getElementsByName('ancien_mdp').values()){
                        alert("Le mot de passe original et l'ancien ne peuvent pas être les mêmes");
                        return false
                    }
                    else
                    {
                        alert("Les nouveaux mdp fournie ne sont pas les mêmes");
                        return false
                    }
            }
        </script>
    </form>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>