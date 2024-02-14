<header>
    <div>
        <img src='../public/img/gsb_logo.png' alt='Logo de GSB' id='gsb_logo'>
    </div>
    <ul>
        <li>Accueil</li>
        <li>Commander</li>
        <?php if ($_SESSION['role'] == ('admin' || 'validator')): ?>
            <li>Valider une commande</li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <li>Gestion des utilisateurs</li>
        <?php endif; ?>
    </ul>
    <div>
        <img src='' alt=''>
        <img src='' alt=''>
    </div>
</header>
