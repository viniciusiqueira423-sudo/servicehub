<?php 
//testando a classe Servico
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "class/Servico.php";

// // testando inserção
// $servico = new Servico();
// $servico->setNome("Limpeza de Piscina");
// $servico->setDescricao("Limpeza completa da piscina, incluindo remoção de folhas e
// detritos, escovação das paredes e aspiração do fundo.");
// $servico->setPreco(150.00);
// if ($servico->inserir()) {
//     echo "Serviço com ID: " . $servico->getId() . "<br>Nome: " . $servico->getNome() . "<br>Descrição: " . $servico->getDescricao() . "<br>Preço: R$ " . number_format($servico->getPreco(), 2, ',', '.') . "<br>Inserido Com Sucesso";
// }

// testando atualização usando o BuscarPorId
// $servico = new Servico();
// $servico->buscarPorId(36);
// $servico->setNome("Limpeza de Piscina Premium");
// $servico->setDescricao("Limpeza completa da piscina, incluindo remoção de folhas e detritos, 
// escovação das paredes e aspiração do fundo, além de tratamento 
// químico para manter a água cristalina por mais tempo.");
// $servico->setPreco(200.00);
// if ($servico->atualizar()) {
//     print_r($servico);
//     echo "Serviço atualizado com sucesso!";
// }

// // testando o metodo listar
// $servicos = Servico::listar();
// foreach ($servicos as $servico) {
//     echo "ID: " . $servico['id'] . "<br>Nome: " . $servico['nome'] . "<br>Descrição: " . $servico['descricao'] . "<br>Preço: R$ " . number_format($servico['preco'], 2, ',', '.') . "<hr>";
// }

// testando o método buscar por id(Novamente já foi comprovado que funciona, apenas testando de novo)
// $servico = new Servico();
// if ($servico->buscarPorId(36)) {
//     echo "ID: " . $servico->getId() . "<br>Nome: " . $servico->getNome() . "<br>Descrição: " . $servico->getDescricao() . "<br>Preço: R$ " . number_format($servico->getPreco(), 2, ',', '.') . "<hr>";
// } else {
//     echo "Serviço não encontrado.";
// }

// testando o método excluir (exclusão lógica usando descontinuado)
// $servico = new Servico();
// $servico->buscarPorId(36);
// if ($servico->excluir()) {
//     echo "Serviço excluído com sucesso!";
// } else {
//     echo "Erro ao excluir serviço.";
// }

// // testando o método listarAtivos
// $servicosAtivos = Servico::listarAtivos();
// foreach ($servicosAtivos as $servico) {
//     echo "ID: " . $servico['id'] . "<br>Nome: " . $servico['nome'] . "<br>Descrição: " . $servico['descricao'] . "<br>Preço: R$ " . number_format($servico['preco'], 2, ',', '.') . "<hr>";
// }

?>