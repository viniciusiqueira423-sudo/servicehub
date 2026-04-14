<?php

function obterPdo(): PDO {



// $host = "10.91.47.48";
$host = "10.91.47.44";
$db = "servicehubdb01"; // nome do banco de dados
$user = "root";
$pass = "P@ssw0rd";

static $pdo;

// PHP.NET
try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "conexão realizada com sucesso!";
    // var_dump($pdo);
}catch(PDOException $erro){
    // var_dump($erro->getMessage());
    die("erro na conexão: ".$erro->getMessage());
}
return $pdo;
}
?>