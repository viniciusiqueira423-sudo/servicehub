<?php

include "config/conexao.php";
     if($_SERVER['REQUEST_METHOD']=="POST"){
         echo "<h3>chamado pelo formulário (POST)</h3>";
         $id = $_POST['txtid'];
         $sql = "select id, nome from servicos where id = :id";
         $cmd = $pdo->prepare($sql);
         $cmd->execute(["id" => $id]);
         $servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);
            var_dump($servicos);
    }
if($_SERVER['REQUEST_METHOD']=="GET")
    echo "<h3>chamado pela URL ou formulário method = 'GET'</h3>";
    $idViaGet = $_GET['txtid'];
    $sql = "select * from servicos where id = :id";
    $cmd = $pdo->prepare($sql);
    $cmd->execute([":id" => $idViaGet]);
    $serviços = $cmd->fetch(PDO::FETCH_ASSOC);
    var_dump($serviços);
?>


<h2>Nome do Serviço: <?= $servico['nome'] ?></h2>
