<?php
require_once 'connect.php';

header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

error_reporting(0);
ini_set(“display_errors”, 0 );

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
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, FILE");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
	
	if(!isset($_POST['descricao']) && !isset($_POST['user']) && !isset($_FILES['foto'])){
		$response['errors'] = true;
		$response['message'] = "Missing Parameteres: ".$_POST['descricao'].$_POST['user'].$_POST['foto'];
		die(json_encode($response));
	}
	
    try {
		
		$imagem = bin2hex(random_bytes(8)).'.'.pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $targetPath = "../fotos/".$imagem;

        if(!move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)){
            $response['errors'] = true;
            $response['message'] = "Error on file" . $targetPath;
            die(json_encode($response));
		}
		
        $PDO->beginTransaction();
        $query = "INSERT INTO publicacoes(id_user, foto, descricao) VALUES (:user, :foto, :descricao)";
		$stmt = $PDO->prepare($query);
        $stmt->bindValue(':user', $_POST['user']);
        $stmt->bindValue(':descricao', $_POST['descricao']);
        $stmt->bindValue(':foto', $imagem);
        $stmt->execute();

        $PDO->commit();
		
		$response['imagem'] = $imagem;
        $response['errors'] = false;
        die(json_encode($response));
       
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }