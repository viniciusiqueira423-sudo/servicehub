<?php

include "config/conexao.php";

$id = $_POST['txtid'];
$sql = "select * from servicos where id = :id";
$cmd = $pdo->prepare($sql);
$cmd->execute(["id" => $id]);
$servico = $cmd->fetch(PDO::FETCH_ASSOC);
?>
<h2>Nome do Serviço: <?= $servico['nome'] ?></h2>