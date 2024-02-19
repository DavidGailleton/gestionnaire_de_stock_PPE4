<div>
    <?php foreach ($_SESSION['medicaments'] as $medicament): ?>
        <?php echo $medicament->getLibelle(); ?>
        <br>
        <?php echo $medicament->getDescription(); ?>
        <br>
        <?php echo $medicament->getQteStock()->toString(); ?>
        <br>
        <?php echo $medicament->getCis()->ToString(); ?>
        <br>
        <?php echo $medicament->getForm(); ?>
        <br>
    <?php endforeach; ?>
</div>
