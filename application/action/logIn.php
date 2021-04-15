<?php
include_once '../core/database/connect.php';
$pdo = new PDO_();

$request = json_decode(file_get_contents("php://input"), true);
$alert=[];

if (empty($request['mail'])) {
    $alert[] = "Не введены данные в поле mail";
}

if (empty($request['password'])) {
    $alert[] = "Не введены данные в поле password";
}

if($pdo->logIn($request['mail'],$request['password'])===false){
    $alert[] = "Пароль или логин были введены неверно";
}


if(empty($alert)){
    try {
        $pdo->logIn($request['mail'],$request['password']);
    }
    catch (PDOException $exception){
        print $exception;
    }
}else {
    http_response_code(400);
    print json_encode($alert);
}

