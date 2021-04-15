<?php
include_once '../core/database/connect.php';

$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
$alert = [];
if (empty($request['mail'])) {
    $alert[] = "Не введены данные в поле mail";
}
if (empty($request['surname'])) {
    $alert[] = "Не введены данные в поле mail";
}
if (empty($request['patronymic'])) {
    $alert[] = "Не введены данные в поле mail";
}
if (empty($request['login'])) {
    $alert[] = "Не введены данные в поле mail";
}
if (empty($request['password'])) {
    $alert[] = "Не введены данные в поле password";
}
if (strlen($request['mail']) < 6 || strlen($request['password']) < 6) {
   $alert[] = "Недопустимое количество символов";
}
if ($pdo->getUserMail($request['mail']) == true) {
   $alert[] = "Пользователь с таким mail уже существует";
}
if (empty($alert)) {
    try {
        $pdo->SignUp($request['mail'], $request['password'], $request['name'], $request['surname'], $request['patronymic'], $request['login']);

    } catch (PDOException $exception) {
        print $exception;
    }
} else {
    http_response_code(400);
    print json_encode($alert);
}