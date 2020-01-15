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

    try {
        $PDO->beginTransaction();
        $query = "SELECT publicacoes.id AS idPub, id_user, data_publicacao AS data, publicacoes.foto AS fotoPub, descricao, utilizadores.nome AS nomeUser, username,  utilizadores.foto AS fotoUser FROM publicacoes, utilizadores WHERE id_user = utilizadores.id ORDER BY publicacoes.id DESC";
        $stmt = $PDO->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll();
		
		error_reporting(0);
		ini_set(“display_errors”, 0 );
		
        if (count($result)) {
            $response['errors'] = false;
            $response['result'] = $result;
            die(json_encode($response));
        } else {
            $response['errors'] = true;
            $response['message'] = "Sem publicações";
            die(json_encode($response));
        }
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }