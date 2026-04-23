<?php
// incluir a conexão
include_once "config/conexao.php";
require_once "class/Usuario.php";
// declara a classe
class Cliente
{
    //atributos
    private $id;
    private $usuario_id;
    private $telefone;
    private $cpf;
    private $pdo;

    //construtor
    public function __construct()
    {
        $this->pdo = obterPdo();
    }
    //Getters / Setters
    //id
    public function getId()
    {
        return $this->id;
    }
    //usuario_id
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function setUsuarioId(int $usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }
    //telefone
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone(string $telefone)
    {
        $this->telefone = $telefone;
    }
    //cpf
    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;
    }
    //métodos obrigatórios - Representam os RFs do projeto
    // inserir
    public function inserir(): bool
    {
        $sql = "INSERT INTO clientes (usuario_id, telefone, cpf)
         values (:usuario_id, :telefone, :cpf)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":usuario_id", $this->usuario_id);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    // atualizar
public function atualizar(): bool
{
    if (empty($this->id)) {
        return false;
    }

    $sql = "UPDATE clientes SET usuario_id = :usuario_id, telefone = :telefone, cpf = :cpf WHERE id = :id";

    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":usuario_id", $this->usuario_id);
    $cmd->bindValue(":telefone", $this->telefone);
    $cmd->bindValue(":cpf", $this->cpf);
    $cmd->bindValue(":id", $this->id);

    return $cmd->execute();
}
    //listar
    public static function listar(): array
    {
        $sql = "SELECT * FROM clientes";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Buscar por id
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        //usando o $dados para prencher os atributos do objeto cliente
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $this->id = $dados['id'];
            $this->usuario_id = $dados['usuario_id'];
            $this->telefone = $dados['telefone'];
            $this->cpf = $dados['cpf'];
            return true;
        }
        return false;
    }
    //Buscar por usuario
    public function buscarPorUsuario(int $usuario_id): bool
    {
        $sql = "SELECT * FROM clientes WHERE usuario_id = :usuario_id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":usuario_id", $usuario_id);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $this->id = $dados['id'];
            $this->usuario_id = $dados['usuario_id'];
            $this->telefone = $dados['telefone'];
            $this->cpf = $dados['cpf'];
            return true;
        }
        return false;
    }
}
