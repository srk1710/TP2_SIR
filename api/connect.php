<?php

$db = "u735217095_sir";
$host = "185.201.11.128";
$user = "u735217095_sir";
$pwd = "sir1920";

try {
    $PDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    var_dump($e->getMessage());
}
?>