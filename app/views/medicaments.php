<?php

use ppe4\controllers\Medicaments;
use ppe4\models\Medicament;

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
    require_once ROOT.'app/controllers/Medicaments.php';
    $medicaments = new Medicaments();
    if (isset($recherche)){
        $nb_page = $medicaments->show_medicaments_card($no_page, $recherche);
    } else {
        $nb_page = $medicaments->show_medicaments_card($no_page, null);
    }
    ?>

    <?php
    include_once ROOT.'app/views/component/choix_de_page.php';
    choix_de_page($no_page, $nb_page, 'medicaments');
    ?>

</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>