<?php
$response['message'] = "ola";
die(json_encode($response));
require_once 'connect.php';

header("Content-Type: application/json");

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
        $stmt->bindValue(":username", $_POST['password']);

        $stmt->execute();

        $result = $stmt->fetch();

        if (count($result)) {
            $response['errors'] = false;
            $response['result'] = $result;
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