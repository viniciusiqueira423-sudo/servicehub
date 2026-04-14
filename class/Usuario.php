<?php
//incluir conexão
include_once "config/conexao.php";
//declara classe
class Usuario
{
    //atributos
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo;
    private $ativo;
    private $primeiro_login;
    private $pdo;
    //contrutor
    public function __construct()
    {
        $this->pdo = obterPdo();
    }
    //Getters e Setters
    //ID
    public function getId(){
        return $this->id;
    }
 
    //Nome
    public function getNome(){
        return $this->nome;
    }
    public function setNome(string $nome){
        $this->nome = $nome;
    }
 
    //Email
    public function getEmail(){
        return $this->email;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
 
    //Senha
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha(string $senha){
        $this->senha = $senha;
    }
 
    //Tipo
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo(string $tipo){
        $this->tipo = $tipo;
    }
 
    //Ativo
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo(string $ativo){
        $this->ativo = $ativo;
    }
 
    //PrimeiroLogin
    public function getPrimeiroLogin(){
        return $this->primeiro_login;
    }
    public function setPrimeiroLogin(string $primeiro_login){
        $this->primeiro_login = $primeiro_login;
    }
    //métodos (funções ou functions)
    //Efetuar Login
    public static function efetuarLogin(string $email, string $senha):array{
        $sql = "select * from usuarios where email = :email and ativo = '1'";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":email", $email);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if($dados && password_verify($senha, $dados['senha'])){
            return $dados;
        }else{
            return $dados = [];
        }
    }
 
 
}