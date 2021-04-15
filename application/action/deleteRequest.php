<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
try {
    $pdo->deleteRequest($request['id_request']);
} catch (PDOException $exception) {
    print $exception;
}