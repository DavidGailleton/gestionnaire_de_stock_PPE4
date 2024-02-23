<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    require_once ROOT.'app/models/Materiel.php';
    $materiel = new \ppe4\Materiel();
    $materiels = $materiel->select_materiels();

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