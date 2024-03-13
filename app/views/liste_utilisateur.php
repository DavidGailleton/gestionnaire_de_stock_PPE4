<?php
require_once ROOT.'app/controllers/Materiels.php';

$numero_page = $_GET['no_page'];
$nombre_page = 0;
if (isset($_GET['recherche'])){
    $recherche = $_GET['recherche'];
} else {
    $recherche = null;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main class="mainListUtilisateur">

    <div>
        <form class="search" action="index.php?action=recherche_utilisateur" method="post">
            <label>
                <input type="search" name="recherche" class="searchTextBox" placeholder="Recherche" <?php if (isset($_GET['recherche'])) echo 'value="'.$_GET['recherche'].'"' ?>>
            </label>
            <button type="submit" class="searchButton">
                <img src="public/img/loupe.svg" alt="rechercher" style="width: 3em">
            </button>
        </form>
    </div>
    <div>
        <?php
        require_once ROOT.'app/controllers/Liste_utilisateur.php';
        $list_utilisateur = new \ppe4\controllers\Liste_utilisateur();

        $nombre_page = $list_utilisateur->afficher_utilisateur_cards($numero_page, $recherche);
        ?>
    </div>
    <div>
        <?php
        include_once ROOT.'app/views/component/choix_de_page.php';
        choix_de_page($numero_page, $nombre_page, 'liste_utilisateur');
        ?>
    </div>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>