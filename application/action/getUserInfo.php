<?php
session_start();
include_once '../core/database/connect.php';
$pdo = new PDO_();
echo json_encode($pdo->getUserInfo());
