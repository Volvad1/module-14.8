<?php

require_once 'config.php';

// возвращает массив - список пользователей
function getUsersList($reload)
{

    if (!key_exists('users', $_SESSION) && !$reload) {
        return [];
    }
    if ($_SESSION['users'] && !$reload) {
        $users = $_SESSION['users'];
    } else {
        if (file_exists(Config::userDataFilePath())) {
            $json = file_get_contents(Config::userDataFilePath());
            $users = json_decode($json, true);
        } else {
            $users = [];
        }
        $_SESSION['users'] = $users;
    }
    return $users;
}

// сохранение списка пользователей
function saveUsersList()
{
    $users = getUsersList(false);
    $json = json_encode($users);

    file_put_contents(Config::userDataFilePath(), $json);
}

// проверяет, существует ли пользователь с указанным логином
function existsUser($login)
{
    $users = getUsersList(false);
    return key_exists($login, $users);
}

// возвращает true тогда, когда существует пользователь 
//с указанным логином и введенный им пароль прошел проверку, иначе — false
function checkPassword($login, $password)
{
    $users = getUsersList(false);
    if (!$users) {
        return false;
    }
    $userPassword = $users[$login]['password'];
    if (!$userPassword) {
        return false;
    }
    $checkPasswHash = sha1($password);
    return $userPassword === $checkPasswHash;
}

// добавление пользователя
function addUser($login, $password)
{
    $users = getUsersList(false);
    $userExists = existsUser($login);
    $users[$login]['password'] = sha1($password);
    // если такого пользователя не было ранее - зададим дату первичной регистрации на сайте
    if (!$userExists) {
        $users[$login]['regdate'] = time();
    }
    $_SESSION['users'] = $users;
    // если такого пользователя не было ранее - сохраним его в файл
    if (!$userExists) {
        saveUsersList();
        // запишем время регистрации (используется для предложение подарочной акции в течении 24 часов после регистрации)
        //$_COOKIE['reg_time'] = time();
        /* переделано на хранение в файле на сервере
        setcookie('reg_time', time(), time() + 86400, '/');
        */
    }
    return true;
}

// изменение пароля пользователем
function changeUserPassword($login, $newPassword)
{
    $users = getUsersList(false);
    $userExists = existsUser($login);
    if (!$userExists) {
        return false;
    }
    $users[$login]['password'] = sha1($newPassword);
    $_SESSION['users'] = $users;
    // сохраним его в файл
    saveUsersList();
    return true;
}

// авторизация пользователя
// возвращает: true-успешно, false-не успешно
function loginUser($login, $password)
{
    $users = getUsersList(true);

    $userExists = existsUser($login);

    if (!$userExists) {
        return false;
    }
    if (sha1($password) === $users[$login]['password']) {
        $_SESSION['user_login'] = $login;
        $_SESSION['user_regdate'] = $users[$login]['regdate'];
        return true;
    } else {
        return false;
    }
}

// разавторизация пользователя
function logoffUser()
{
    unset($_SESSION['user_login']);
    unset($_SESSION['user_regdate']);
    unset($_SESSION['user_birthday']);
}

// возвращает либо имя вошедшего на сайт пользователя, либо null
function getCurrentUser()
{
    if (!key_exists('user_login', $_SESSION)) {
        return null;
    }
    if (!$_SESSION['user_login']) {
        return null;
    } else {
        $login = $_SESSION['user_login'];
        return $login;
    }
}

// возвращает либо дату регистрации вошедшего на сайт пользователя, либо null
function getUserRegDate()
{
    if (!key_exists('user_regdate', $_SESSION)) {
        return null;
    }
    if (!$_SESSION['user_regdate']) {
        return null;
    } else {
        $regdate = $_SESSION['user_regdate'];
        return $regdate;
    }
}

// сохранение/изменение профиля пользователем
// в файл user.dat
// в идеале - отдельный файл, но для учебного примера - сойдет ))
function saveUserProfile($login, $fullname, $birthday)
{
    $users = getUsersList(false);
    $userExists = existsUser($login);
    if (!$userExists) {
        return false;
    }
    $users[$login]['fullname'] = $fullname;
    $users[$login]['birthday'] = $birthday;


    $_SESSION['users'] = $users;
    $_SESSION['user_birthday'] = $birthday;

    // сохраним его в файл
    saveUsersList();
    return true;
}

// возвращает либо ФИО пользователя, либо null
function getUserFullName($login)
{
    $users = getUsersList(false);
    if (!existsUser($login)) {
        return null;
    }
    if (!key_exists('fullname', $users[$login])) {
        return null;
    }
    return $users[$login]['fullname'];
}

// возвращает либо дату рождения пользователя, либо null
function getUserBirthday($login)
{
    // сначала ищем в сессии   
    if (key_exists('user_birthday', $_SESSION) && key_exists('user_login', $_SESSION) && $login === $_SESSION['user_login']) {
        return $_SESSION['user_birthday'];
    } else {
        // если в сессии нет - ищем в файле
        $users = getUsersList(false);
        if (!existsUser($login)) {
            return null;
        }
        if (!key_exists('birthday', $users[$login])) {
            return null;
        }
        $birthday = $users[$login]['birthday'];
        $_SESSION['user_birthday'] = $birthday;

        return $birthday;
    }
}
