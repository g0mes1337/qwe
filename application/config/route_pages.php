<?php

$pages = [
    '' => [
        'title' => 'Главная',
        'link' => 'main_s.html',
        'scripts' => ['test', 'courses_input_main']
    ],
    'add_request' => [
        'title' => 'Создание заявки',
        'link' => 'add_request.html',
        'scripts' => ['test']

    ],
    'admin_panel' => [
        'title' => 'Панель администратора',
        'link' => 'admin_panel.html',
        'scripts' => ['test','addCategory']
    ],
    'private' => [
        'title' => 'Личный кабинет',
        'link' => 'private.html',
        'scripts' => ['test']

    ],

    '404' => [
        'title' => 'Не найдено',
        'link' => '404.html',
        'scripts' => ['test']

    ],
    'logIn' => [
        'title' => 'Авторизация',
        'link' => 'logIn.html',
        'scripts' => ['test']
    ],
    'signUp' => [
        'title' => 'Регистрация',
        'link' => 'signUp.html',
        'scripts' => ['test']
    ]

];
