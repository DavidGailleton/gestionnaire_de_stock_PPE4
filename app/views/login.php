<!doctype html>
<html lang="en">
<head>
    <?php require_once (ROOT."./app/views/component/head.php") ?>
</head>
<body>
    <div>

    </div>
    <main>
        <div class="login_card">
            <div class="login_content">
                <h2>Login</h2>
                <form action="index.php?action=login" method="post" id="login">
                    <input type="email" name="email" class="text_box" placeholder="Addresse e-mail">
                    <input type="password" name="password" class="text_box" placeholder="Mot de passe">
                    <input type="submit" value="connect">
                </form>
            </div>
        </div>
    </main>
    <footer>
        Copyright GSB
    </footer>
</body>
</html>