<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>

    <div>
        <form class="search" action="index.php?action=recherche_medicament" method="post">
            <label>
                <input type="text" name="recherche" class="searchTextBox" placeholder="Recherche" <?php if (isset($_GET['recherche'])) echo 'value="'.$_GET['recherche'].'"' ?>>
            </label>
            <button type="submit" class="searchButton">
                <img src="public/img/loupe.svg" alt="rechercher" style="width: 3em">
            </button>
        </form>
    </div>

<?php
require_once ROOT.'app/controllers/Liste_utilisateur.php';
$list_utilisateur = new \ppe4\controllers\Liste_utilisateur();
$list_utilisateur->afficher_utilisateur_cards();
?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>