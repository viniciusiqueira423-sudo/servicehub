<?php 
// $senha = password_hash("123456",PASSWORD_DEFAULT);
// echo $senha;


require_once "class/Usuario.php";

$usuario = new Usuario();
$usuario->setNome("Vinicus Siqueira");
$usuario->setEmail("vinicusiqueira423@gmail.com");
$usuario->setSenha("Vini_423");
$usuario->setTipo(2);

if ($usuario->inserir()) {
    echo "Usuario". $usuario->getNome()." inserido com sucesso com o ID: ". $usuario->getId();
}