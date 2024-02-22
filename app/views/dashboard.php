<!doctype html>
<html lang="en">
<?php require_once ROOT."app/views/component/head.php" ?>
<body>
 <?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <a href=<?php echo SERVER_URL.'index.php?page=medicaments' ?>>
        Medicaments
    </a>
    <a href=<?php echo SERVER_URL.'index.php?page=materiels' ?>>
        Materiels
    </a>
</main>
 <?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>