<?php
/* -------------- обработка входа/выхода/сохранения профиля --------------- */

session_start();
require_once 'user.php';

if (!empty($_REQUEST)) {
    // вызов со страницы профиля
    if (key_exists('profile', $_POST)) {
        if (key_exists('login', $_POST)) {
            $login = $_POST['login'];
            if (key_exists('fullname', $_POST)) {
                $fullname = $_POST['fullname'];
            }
            if (key_exists('birthday', $_POST)) {
                $birthday = $_POST['birthday'];
            }
            // сохраняем профиль
            saveUserProfile($login, $fullname, $birthday);
            // надо бы добавить сообщение об успешном сохранении профиля, но как-нибудь потом...    
            // посылаем на главную
            header('Location: /');
        }
        die('Ошибка сохранения профиля пользователя');
    }
    // вызов со страницы регистрации
    elseif (key_exists('register', $_POST)) {
        if (key_exists('login', $_POST)) {
            $login = $_POST['login'];
            if (key_exists('password', $_POST)) {
                $password = $_POST['password'];
                // добавляем пользователя
                if (addUser($login, $password)) {
                    // и сразу логинимся
                    if (loginUser($login, $password)) {
                        header('Location: /');
                    }
                }
            }
            die('Ошибка регистрации  пользователя');
        }
        die('Ошибка регистрации  пользователя');
    }
    // вызов со страницы входа
    elseif (key_exists('login', $_POST)) {
        $login = $_POST['login'];
        if (key_exists('password', $_POST)) {
            $password = $_POST['password'];
            // делаем логин
            if (loginUser($login, $password)) {
                header('Location: /');
            } else {
                // неудача
                // проверяем: есть ли такой пользователь?
                if (existsUser($login)) {
                    // если есть - говорим ему, что неправильный пароль
                    header('Location: login.php?error');
                } else {
                    // если нет - отправляем на регистрацию
                    header('Location: register.php?login=' . $login);
                }
            }
        }
        die('Ошибка входа пользователя');
    }
    // выход пользователя
    elseif (key_exists('logoff', $_REQUEST)) {
        logoffUser();
        // идем на главную
        header('Location: /');
    }
}
die('Ошибка операции входа/выхода');
