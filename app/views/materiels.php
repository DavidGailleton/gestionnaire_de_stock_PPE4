<?php
require_once ROOT.'app/controllers/Materiels.php';

$numero_page = $_GET['no_page'];
$nombre_page = 0;
if (isset($_GET['recherche'])){
    $recherche = $_GET['recherche'];
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

    <div>
        <form class="search" action="index.php?action=recherche_materiel" method="post">
            <label>
                <input type="text" name="recherche" class="searchTextBox" placeholder="Recherche" <?php if (isset($_GET['recherche'])) echo 'value="'.$_GET['recherche'].'"' ?>>
            </label>
            <button type="submit" class="searchButton">
                <img src="public/img/loupe.svg" alt="Recherche" style="width: 3em">
            </button>
        </form>
    </div>

    <?php
    $materiels = new \ppe4\controllers\Materiels();
    if (isset($recherche)){
        $nombre_page = $materiels->afficher_materiels_card($numero_page, $recherche);
    } else {
        $nombre_page = $materiels->afficher_materiels_card($numero_page, null);
    }
    ?>

    <?php
    include_once ROOT.'app/views/component/choix_de_page.php';
    choix_de_page($numero_page, $nombre_page, 'materiels');
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>