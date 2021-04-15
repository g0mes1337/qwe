<?php
session_start();
$routes = preg_split('/[\/?]/', $_SERVER['REQUEST_URI']);
include 'route.php';
