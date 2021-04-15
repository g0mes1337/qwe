<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);

$alert = [];
if (empty($request['name'])) {
    $alert[] = "Не введены данные в поле Наименование";
}
if (empty($request['description'])) {
    $alert[] = "Не введены данные в поле Описание";
}

if (empty($request['photo'])) {
    $alert[] = "Не введены данные в поле Фото";
}
if (empty($alert)) {
    try {
        $pdo->addRequest($request['name'], $request['description'], $request['id'], $request['photo']);

    } catch (PDOException $exception) {
        print $exception;
    }
} else {
    http_response_code(400);
    print json_encode($alert);
}