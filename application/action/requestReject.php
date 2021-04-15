<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
var_dump($pdo->checkRequest($request['id_request']));
if ($pdo->checkRequest($request['id_request']) == "Новая") {
    try {
        $pdo->requestReject($request['id_request']);
    } catch (PDOException $exception) {
        print $exception;
    }
}
