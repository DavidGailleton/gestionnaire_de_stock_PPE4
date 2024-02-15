<!doctype html>
<html lang="en">
<?php require_once (ROOT."./app/views/component/head.php") ?>
<body>
    <main>
        <div class="login_card">
            <div class="login_content">
                <h2>Login</h2>
            <form action=<?php echo ROOT.'app/controllers/Main.php'?> method="post" id="login">
                    <input type="text" name="email" class="text_box">
                    <input type="password" name="password" class="text_box">
                    <input type="submit" value="Se connecter">
                </form>
            </div>
        </div>
    </main>
</body>
</html>