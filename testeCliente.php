<?php 
require_once "class/Cliente.php";
// ini_set('display_errors',1);
// ini_set('display_startup_erros', 1);
// error_reporting(E_ALL);
 
//  $cliente = new Cliente();
//  $cliente ->setUsuarioId(1);
//  $cliente ->setTelefone('11987654346');
//  $cliente ->setCpf('11122233355');
//  if ($cliente->inserir()){
//      echo "Cliente com ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<br>Inserido Com Sucesso";
//  }


// // testando Atualização usando o BuscarPorId
// $cliente = new Cliente();
// $cliente->buscarPorId(1);
// $cliente->setTelefone('11999997799');
// $cliente->setCpf('11122233344');
// if($cliente->atualizar()){
//     print_r($cliente);
//     echo "Cliente atualizado com sucesso!";
// }

// testando o metodo listar
// $clientes = Cliente::listar();
// foreach($clientes as $cliente){
//     echo "ID: ".$cliente['id']."<br>Telefone: ".$cliente['telefone']."<br> CPF: " . $cliente['cpf'] . "<hr>";
// }

// //testando o método buscar por id(já foi comprovado que funciona, apenas testando novamente)
// $cliente = new Cliente();
// if($cliente->buscarPorId(1)){
//     echo "ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<hr>";
// }else{
//     echo "Cliente não encontrado.";
// }

// testando o método buscar por id_usuario
// $cliente = new Cliente();
// if($cliente->buscarPorUsuario(1)){
//     echo "ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<hr>";
// }else{
//     echo "Cliente não encontrado.";
// }
