<?php
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
    require_once ROOT.'app/models/Medicament.php';
    $medicament = new \ppe4\models\Medicament();
    if (isset($recherche)){
        $medicaments = $medicament->select_medicaments_par_recherche(($no_page - 1) * 25, $recherche);
        $nb_page = intval(ceil($medicament->count_nb_medicament_par_recherche($recherche) / 25));
    } else {
        $medicaments = $medicament->select_medicaments(($no_page - 1) * 25);
        $nb_page = intval(ceil($medicament->count_nb_medicament() / 25));
    }

    include_once ROOT.'app/views/component/medic_card.php';
    $i = 0;
    foreach ($medicaments as $item){
        echo medic_card($item, $i);
        $i++;
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