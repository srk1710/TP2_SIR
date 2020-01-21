<?php
require_once 'connect.php';

header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

error_reporting(0);
ini_set("display_errors", 0);

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    // may also be using PUT, PATCH, HEAD etc
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, FILE");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}

if (!isset($_POST['idSegue']) || !isset($_POST['idSeguido']) || !isset($_POST['seguir']) {
    $response['errors'] = true;
    $response['message'] = "Missing Parameteres";
    die(json_encode($response));
}

if ($_POST['seguir']) {

    try {

        $PDO->beginTransaction();
        $query = "INSERT INTO seguir (id_segue, id_seguido) VALUES (:id_segue, :id_seguido)";
        $stmt = $PDO->prepare($query);
        $stmt->bindValue(':id_segue', $_POST['idSegue']);
        $stmt->bindValue(':id_seguido', $_POST['idSeguido']);
        $stmt->execute();
        $PDO->commit();

        $response['errors'] = false;
        die(json_encode($response));
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }
} else {

    try {

        $PDO->beginTransaction();
        $query = "DELETE FROM seguir WHERE id_segue=:id_segue AND id_seguido=:id_seguido";
        $stmt = $PDO->prepare($query);
        $stmt->bindValue(':id_segue', $_POST['idSegue']);
        $stmt->bindValue(':id_seguido', $_POST['idSeguido']);
        $stmt->execute();
        $PDO->commit();

        $response['errors'] = false;
        die(json_encode($response));
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }
}