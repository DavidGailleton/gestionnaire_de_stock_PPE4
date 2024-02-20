<!doctype html>
<html lang="en">
<?php require_once ROOT."app/views/component/head.php" ?>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    require_once ROOT.'app/models/Medicament.php';
    $medicament = new \ppe4\Medicament();
    $medicaments = $medicament->select_medicaments();

    include_once ROOT.'app/views/component/medic_card.php';
    foreach ($medicaments as $item){
        echo medic_card($item);
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>