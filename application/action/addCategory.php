<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
$alert = [];
if (empty($request['category'])) {
    $alert[] = "Не введены данные в поле Категория";
}
if (empty($alert)) {
    try {
        $pdo->addCategory($request['category']);

    } catch (PDOException $exception) {
        print $exception;
    }
} else {
    http_response_code(400);
    print json_encode($alert);
}