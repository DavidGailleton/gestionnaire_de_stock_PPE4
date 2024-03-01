<?php
require_once ROOT.'app/controllers/Materiels.php';

$no_page = $_GET['no_page'];
$nb_page = 0;
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
        $nb_page = $materiels->show_materiels_card($no_page, $recherche);
    } else {
        $nb_page = $materiels->show_materiels_card($no_page, null);
    }
    ?>

    <?php
    include_once ROOT.'app/views/component/choix_de_page.php';
    choix_de_page($no_page, $nb_page, 'materiels');
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>