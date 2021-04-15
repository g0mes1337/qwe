<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
if($pdo->checkRequest($request['id_request'])=='Новая' ){
    try {
        $pdo->requestAccess($request['id_request']);
    } catch (PDOException $exception) {
        print $exception;
    }
}
else{
    http_response_code(400);
}