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
    $medicament = new \ppe4\Medicament();
    if (isset($recherche)){
        $medicaments = $medicament->select_medicaments_par_recherche(($no_page - 1) * 25, $recherche);
        $nb_page = intval(round($medicament->count_nb_medicament_par_recherche($recherche) / 25, 0, PHP_ROUND_HALF_EVEN));
    } else {
        $medicaments = $medicament->select_medicaments(($no_page - 1) * 25);
        $nb_page = intval(round($medicament->count_nb_medicament() / 25, 0, PHP_ROUND_HALF_EVEN));
    }

    include_once ROOT.'app/views/component/medic_card.php';
    $i = 0;
    foreach ($medicaments as $item){
        echo medic_card($item, $i);
        $i++;
    }
    ?>

    <div class="choix_de_page" style="grid-template-columns: <?php for($i=0; $i < $nb_page && $i < 11; $i++) echo '1fr ' ?>">
        <?php
        if ($no_page != 1 && $nb_page > 9) {
            echo '<button onclick="redirect('.$no_page - 1 .')"><</button>';
        }
        echo '<button onclick="redirect(1)">1</button>';
        if ($nb_page > 1){
            if ($nb_page < 10 || $no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect(2)">2</button>';
            } else {
              echo '<button>...</button>';
            }
        }
        if ($nb_page  > 2) {
            if ($nb_page < 10 || $no_page > $nb_page - 3 || $no_page < 4){
                echo '<button onclick="redirect(3)">3</button>';
            }else{
                echo '<button onclick="redirect('.$no_page - 2 .')">'.$no_page - 2 .'</button>';
            }
        }
        if ($nb_page > 3){
            if ($nb_page < 10 || $no_page > $nb_page - 3 || $no_page < 4){
                echo '<button onclick="redirect(4)">4</button>';
            } else {
                echo '<button onclick="redirect('.$no_page - 1 .')">'. $no_page - 1 .'</button>';
            }
        }
        if ($nb_page > 4){
            if ($nb_page < 10){
                echo '<button onclick="redirect(5)">5</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button>...</button>';
            } else {
                echo '<button>'. $no_page .'</button>';
            }
        }
        if ($nb_page > 5){
            if ($nb_page < 10){
                echo '<button onclick="redirect(6)">6</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 3 .')">'.$nb_page - 3 .'</button>';
            } else {
                echo '<button onclick="redirect('.$no_page + 1 .')">'. $no_page + 1 .'</button>';
            }
        }
        if ($nb_page > 6){
            if ($nb_page < 10){
                echo '<button onclick="redirect(7)">7</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 2 .')">'.$nb_page - 2 .'</button>';
            } else {
                echo '<button onclick="redirect('.$no_page + 2 .')">'. $no_page + 2 .'</button>';
            }
        }
        if ($nb_page > 7){
            if ($nb_page < 10){
                echo '<button onclick="redirect(8)">8</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 1 .')">'.$nb_page - 1 .'</button>';
            } else {
                echo '<button>...</button>';
            }
        }
        if ($nb_page > 8){
            echo '<button onclick="redirect('.$nb_page.')">'. $nb_page .'</button>';
        }
        if ($nb_page > 9 && $no_page != $nb_page){
            echo '<button onclick="redirect('.$no_page + 1 .')">></button>';
        }
        ?>
    </div>
    <script>
        function redirect (no_page){
            <?php
            if (isset($_GET['recherche'])){
                echo 'window.location.href = "'.SERVER_URL.'index.php?page=medicaments&recherche='.$_GET['recherche'].'&no_page="+no_page';
            }else{
                echo 'window.location.href = "'.SERVER_URL.'index.php?page=medicaments&no_page="+no_page';
            }
            ?>
        }
    </script>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>