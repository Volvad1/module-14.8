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
  <link rel="stylesheet" href="../css/style.css">
  <title>SPA-салон "Золотой лотос". Ваш профиль"</title>
</head>

<body>
  <?php
  session_start();
  include_once 'user.php';
  include_once 'head.php';

  $login = getCurrentUser();
  if (!$login) {
    echo '<div style="text-align: center; color: #cddd63;">';
    echo '<br><h1>Вы не вошли на сайт</h1><br>';
    echo '<p><a href="login.php">Войдите</a> или <a href="profile.php">Зарегистрируйтесь</a></p>';
    echo '<br><p><a href="/">Перейти на главную страницу сайта</a></p>';
    echo '</div>';
    die();
  }

  $fullname = getUserFullName($login);
  $birthday = getUserBirthday($login);
  ?>
  <main>
    <div class="input-box profile-box">
      <div class="login-box-title">Профиль: <?= $login ?></div>
      <div class="login-box-note">Ваши данные. Не забудьте указать дату рождения, что бы получить подарок!</div>
      <form action="auth.php" method="post" class="login-form">
        <label for="fullname">Полное имя (ФИО):</label>
        <input name="fullname" type="text" placeholder="..." class="inpt" value="<?= $fullname ?>">
        <label for="birthday">Дата рождения:</label>
        <input name="birthday" type="date" placeholder="..." class="inpt" value="<?= $birthday ?>">
        <input name="profile" type="hidden" value="1">
        <input name="login" type="hidden" value="<?= $login ?>">
        <input name="submit" type="submit" value="Сохранить" class="btn">
        <input name="button" type="button" value="Отмена" onclick="location='/'" class="btn">
      </form>
    </div>

  </main>
</body>

</html>