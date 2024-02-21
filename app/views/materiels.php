<!doctype html>
<html lang="fr">
<?php require_once ROOT."app/views/component/head.php" ?>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    require_once ROOT.'app/models/Materiel.php';
    $materiel = new \ppe4\Materiel();
    $materiels = $materiel->select_materiels();

    include_once ROOT.'app/views/component/materiel_card.php';
    foreach ($materiels as $item){
        echo materiel_card($item);
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>