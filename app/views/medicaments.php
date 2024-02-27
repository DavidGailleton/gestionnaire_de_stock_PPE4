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
                <img src="public/img/loupe.svg" style="width: 3em">
            </button>
        </form>
    </div>

    <?php
    require_once ROOT.'app/models/Medicament.php';
    $medicament = new \ppe4\Medicament();
    if (isset($_GET['recherche'])){
        $medicaments = $medicament->select_medicaments_par_recherche(($_GET['no_page'] - 1) * 25, $_GET['recherche']);
    } else {
        $medicaments = $medicament->select_medicaments(($_GET['no_page'] - 1) * 25);
    }

    include_once ROOT.'app/views/component/medic_card.php';
    $i = 0;
    foreach ($medicaments as $item){
        echo medic_card($item, $i);
        $i++;
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>