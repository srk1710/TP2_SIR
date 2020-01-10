<?php
require_once 'connect.php';

header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $response['errors'] = true;
    $response['message'] = "Parâmetros em falta";
    die(json_encode($response));
} else {

    try {
        $PDO->beginTransaction();
        $query = "SELECT username FROM utilizadores WHERE username = :username && password = :password";
        $stmt = $PDO->prepare($query);

        $stmt->bindValue(":username", $_POST['username']);
        $stmt->bindValue(":password", $_POST['password']);

        $stmt->execute();

        $result = $stmt->fetchAll();
		
		error_reporting(0);
		ini_set(“display_errors”, 0 );
		
        if (count($result)) {
            $response['errors'] = false;
            $response['result'] = $result[0]['username'];
            die(json_encode($response));
        } else {
            $response['errors'] = true;
            $response['message'] = "Dados errados";
            die(json_encode($response));
        }
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }
}