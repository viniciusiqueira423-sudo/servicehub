<?php 
// $senha = password_hash("123456",PASSWORD_DEFAULT);
// echo $senha;
//mudança de senha: o usuário deve informar a senha atual para poder alterar a senha, 
//e a nova senha deve ser confirmada (digitar a nova senha duas vezes para evitar erros de digitação)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "class/Usuario.php";

// testando update
$usuario = new Usuario();// objeto vazio
$usuario->buscarPorId(56);
if($usuario->atualizarSenha(password_hash("123456", PASSWORD_DEFAULT))){
    echo "Senha do usuário ".$usuario->getNome()." atualizada com sucesso!";
}

?>