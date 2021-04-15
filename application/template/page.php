<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DosLab</title>
    <link rel="stylesheet" href="assets/css/style_main.css">
    <link rel="icon" href="assets/image/clover.png">
    <?= $scripts ?>
</head>
<body>
<header>
    <nav class="navbar">
        <a class="logo" href="/">Сделаем лучше вместе!</span></a>
        <div class="header">
            <div class="head_container">
                <ul class="head">
                </ul>
                <?php if (isset($_SESSION['mail']) && $_SESSION['root'] == "0") {
                    ?>
                    <ul class="head_2">
                        <li><a href="private">Личный кабинет</a></li>
                        <li><a href="add_request">Создать заявку</a></li>
                        <li><a href="" onclick="LogOut();">Выход</a></li>
                    </ul>
                    <?php
                } else if (!isset($_SESSION['mail']) && $_SESSION['root'] == "0" && !isset($_SESSION['id_user']) && !isset($_SESSION['name'])) { ?>
                    <ul class="head_2">
                        <li><a href="signUp">Зарегистрироваться</a></li>
                        <li><a href="logIn">Войти</a></li>
                    </ul>
                    <?php
                } else if (empty($_SESSION)) {
                    ?>
                    <ul class="head_2">
                        <li><a href="signUp">Зарегистрироваться</a></li>
                        <li><a href="logIn">Войти</a></li>
                    </ul><?php } ?>

                <?php if ($_SESSION['root'] == "1") { ?>
                    <ul class="head_2">
                        <li><a href="admin_panel">Админ-панель</a></li>
                        <li><a onclick="LogOut();">Выход</a></li>

                    </ul><?php
                }
                ?>

            </div>
        </div>
    </nav>
</header>
<?= $content ?>

</body>
</html>