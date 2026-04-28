<?php
require_once "class/Solicitacao.php";

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Teste Inserir
$solicitacao = new Solicitacao();
$solicitacao->setClienteId(1);
$solicitacao->setDescricaoProblema("Problema no sistema");
$solicitacao->setDataPreferida("2026-04-30 14:00:00");
$solicitacao->setEndereco("Rua Exemplo, 123");

if ($solicitacao->inserir()){
    echo "Solicitação inserida com ID: " . $solicitacao->getId();
} else {
    echo "Erro ao inserir solicitação";
}
?>