<?php
include_once "config/conexao.php";

$sql = "select * from servicos";
$cmd = $pdo->prepare($sql);
$cmd->execute();


$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);
var_dump($servicos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula PDO PHP</title>
</head>
<body>
    <h2>Lista de Serviços</h2>
    
</body>
</html>