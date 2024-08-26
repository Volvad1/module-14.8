<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <title>Регистрация в SPA-салоне "Золотой лотос"</title>
</head>

<body>
    <?php
    session_start();
    include_once 'user.php';
    include_once 'head.php';

    ?>
    <main>
        <div class="input-box login-box">
            <div class="login-box-title">Регистрация</div>
            <div class="login-box-note">Или <a href="login.php">войдите</a>, если Вы уже регистрировались</div>
            <form action="auth.php" method="post" class="login-form">
                <label for="login">Имя пользователя:</label>
                <input name="login" type="text" placeholder="..." class="inpt" value="<?= (key_exists('login', $_REQUEST)) ? $_REQUEST['login'] : null ?>">
                <label for="password">Пароль:</label>
                <input name="password" type="password" placeholder="..." class="inpt">
                <input name="register" type="hidden" value="1">
                <input name="submit" type="submit" value="Регистрация" class="btn">
                <input name="button" type="button" value="Отмена" onclick="location='/'" class="btn">
            </form>
        </div>
    </main>
</body>

</html>