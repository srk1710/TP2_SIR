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
	
	if(!isset($_POST['idUser']) || !isset($_POST['idLogado']) ){
		$response['errors'] = true;
		$response['message'] = "Missing Parameteres";
		die(json_encode($response));
	}
	
    try {
        $PDO->beginTransaction();
        $query = "SELECT (SELECT CASE WHEN id_segue = :idLogado AND id_seguido = :idUser2 THEN true ELSE false END AS existe FROM seguir WHERE id_segue = :idLogado0 AND id_seguido = :idUser0) AS segue,
		(SELECT count(id_segue) FROM seguir WHERE id_seguido = :userA) AS seguidores,
		(SELECT count(id_seguido) FROM seguir WHERE id_segue = :userB) AS aSeguir,
		(SELECT count(publicacoes.id) FROM publicacoes, utilizadores WHERE id_user = utilizadores.id AND id_user = :idUser1) AS count, publicacoes.id AS idPub, publicacoes.foto AS fotoPub, descricao, data_publicacao, username, bio, nome, utilizadores.foto AS fotoUser, utilizadores.id AS idUser FROM publicacoes, utilizadores WHERE id_user = utilizadores.id AND id_user = :idUser ORDER BY publicacoes.id DESC";
        $stmt = $PDO->prepare($query);
        $stmt->bindValue(':idLogado', $_POST['idLogado']);
        $stmt->bindValue(':idUser1', $_POST['idUser']);
		
        $stmt->bindValue(':idLogado0', $_POST['idLogado']);
        $stmt->bindValue(':idUser0', $_POST['idUser']);
		
        $stmt->bindValue(':userA', $_POST['idUser']);
        $stmt->bindValue(':userB', $_POST['idUser']);
		
        $stmt->bindValue(':idUser2', $_POST['idUser']);
        $stmt->bindValue(':idUser', $_POST['idUser']);

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
            $response['message'] = "Sem publicações para o user" . $_POST['idUser'];
            die(json_encode($response));
        }
    } catch (PDOException $e) {
        $response['errors'] = true;
        $response['message'] = $e->getMessage();
        die(json_encode($response));
    }