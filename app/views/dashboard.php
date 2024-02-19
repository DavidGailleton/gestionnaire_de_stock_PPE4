<!doctype html>
<html lang="en">
<?php require_once ROOT."app/views/component/head.php" ?>
<body>
 <?php include_once ROOT."app/views/component/header.php"; ?>

<?php
 $medicament = new \ppe4\Medicament();
 $medicaments = $medicament->select_medicaments();


 foreach ($medicaments as $item){
     $_SESSION['medicaments'][] = $item;
     echo 'test';
 }

 require_once ROOT.'app/views/component/medic_card.php';
 ?>
</body>
</html>