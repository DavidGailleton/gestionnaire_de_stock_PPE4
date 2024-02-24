<?php
if (!$_POST['email'] || !isset($_COOKIE['JWT'])){
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
    <form id="formulaire_nouveau_mdp" onsubmit="verifier_mdp()">
        <label>
            <input type="password" name="ancien_mdp">
        </label>
        <label>
            <input type="password" name="nouveau_mdp">
        </label>
        <label>
            <input type="password" name="confirmation_nouveau_mdp">
        </label>
        <input type="submit">
        <script>
            function verifier_mdp() {
                document.getElementById("formulaire_nouveau_mdp").addEventListener("submit", function()){
                    if (document.getElementsByName('nouveau_mdp') === document.getElementsByName('confirmation_nouveau_mdp')){
                        document.getElementById('formulaire_nouveau_mdp').method('post').action(<?php echo SERVER_URL.'index.php?action=modifier_mdp' ?>)
                    }
                    else
                    {
                        document.getElementById('message_d_erreur').style.display = "contents";
                        alert("Les nouveaux mdp fournie ne sont pas les mêmes");
                    }
                }
            }
            window.onload = function() {
                document.getElementById("formulaire_nouveau_mdp").addEventListener("submit", function()){
                    const champCache = document.createElement("input")
                    champCache.type = "hidden";
                    champCache.name = "email";
                    champCache.value = '<?php echo $_POST['email'] ?>'
                    this.appendChild(champCache)
                }
            }
        </script>
    </form>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>