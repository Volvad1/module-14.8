<?php

include_once 'user.php';

$login = getCurrentUser();

?>
<div class="topnav">
    <div class="page_title">SPA-салон "Золотой лотос"</div>
    <div class="user_name">
        <a href=<?php
                if (!$login) {
                    echo '"/php/login.php">Войти';
                } else {
                    echo '"/php/profile.php">' . $login;
                }
                ?> </a>
    </div>
    <div class="top_menu_btn">
        <a id="btnLink" href="javascript:void(0);" class="dropbtn barbtn">
            <i class="fa fa-bars barbtn"></i>
        </a>
    </div>
</div>
<!--<nav class="sidenav"> -->
<div id="myDropdown" class="dropdown-content">
    <h3 class="widget-title">Услуги</h3>
    <ul class="widget-list">
        <li><a href="/">Релакс</a></li>
        <li><a href="/">Оздоровление</a></li>
        <li><a href="/">Красота</a></li>
        <li><a href="/">Акции</a></li>
        <li><a href="/">Магазин</a></li>
    </ul>
    <p></p>
    <h3 class="widget-title">О нас</h3>
    <ul class="widget-list">
        <li><a href="/">Салоны</a></li>
        <li><a href="/">Лицензии</a></li>
    </ul>
    <p></p>
    <h3 class="widget-title">О Вас</h3>
    <ul class="widget-list">
        <?php if ($login) { ?>
            <li><a href="/php/profile.php">Ваш профиль</a></li>
            <li><a href="/php/auth.php?logoff">Выйти</a></li>
        <?php } else { ?>
            <li><a href="/php/login.php">Войти</a></li>
        <?php } ?>
    </ul>
</div>
<!--</nav>-->

<script src="../js/head.js"></script>