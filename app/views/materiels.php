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
                <img src="public/img/loupe.svg" style="width: 3em">
            </button>
        </form>
    </div>

    <?php
    require_once ROOT.'app/models/Materiel.php';
    $materiel = new \ppe4\Materiel();
    if (isset($_GET['recherche'])){
        $materiels = $materiel->select_materiels_par_recherche($_GET['recherche'], ($_GET['no_page'] - 1) * 25);
    } else {
        $materiels = $materiel->select_materiels(($_GET['no_page'] - 1) * 25);
    }

    include_once ROOT.'app/views/component/materiel_card.php';
    $i =0;
    foreach ($materiels as $item){
        echo materiel_card($item, $i);
        $i++;
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>