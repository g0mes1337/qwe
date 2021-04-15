<?php
session_start();
include_once '../core/database/connect.php';
$pdo = new PDO_();
$request = json_decode(file_get_contents("php://input"), true);
try {
    if (isset($_SESSION['id_user'])) {
       $user=$pdo->getUser();
    }
} catch (PDOException $exception) {
    print $exception;
}
echo  json_encode($user);
