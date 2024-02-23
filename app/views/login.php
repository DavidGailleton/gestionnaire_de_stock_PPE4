<!doctype html>
<html lang="en">
<head>
    <?php require_once (ROOT."./app/views/component/head.php") ?>
</head>
<body>
    <main>
        <div class="login_card">
            <div class="login_content">
                <h2>Login</h2>
                <form action="<?php echo 'index.php?action=login'?>" method="post" id="login">
                    <input type="text" name="email" class="text_box">
                    <input type="password" name="password" class="text_box">
                    <input type="submit" value="connect">
                </form>
            </div>
        </div>
    </main>
</body>
</html>