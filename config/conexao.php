<?php

$host = "10.91.47.44";
$db = "servicehubdb01";
$user = "root";
$pass = "P@ssw0rd";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass)
}catch(PDOException $erro){
    die("erro na conexão: ".$erro->getMensage());
}