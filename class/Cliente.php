<?php
//incluir conexão
include_once "config/conexao.php";
//declara classe
class Cliente
{
    //atriubutos
    private $pdo;
    private $id;
    private $usuario_id;
    private $telefone;
    private $cpf;
    //contrutor
    public function __construct()
    {
        $this->pdo = obterPdo();
    }
    //Getters e Setters
    //ID
    public function getId()
    {
        return $this->id;
    }
    //USUARIO_ID
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function setUsuarioId(int $usuario_id)
    {
        return $this->usuario_id = $usuario_id;
    }
    //TELEFONE
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone(string $telefone)
    {
        return $this->telefone = $telefone;
    }
    //CPF
    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf(string $cpf)
    {
        return $this->cpf = $cpf;
    }

    //Métodos Obrigatórios
    //Inserir
    public function inserir(): bool
    {
        $sql = "INSERT into clientes (usuario_id, telefone, cpf) values(:usuario_id, :telefone, :cpf)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":usuario_id", $this->usuario_id);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();;
            return true;
        }
        return false;
    }
    //Buscar po ID
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if ($cmd->rowCount() > 0) { // rowCount conta as linha
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            $this->id = $dados['id'];
            $this->setUsuarioId($dados['usuario_id']);
            $this->setTelefone($dados['telefone']);
            $this->setCpf($dados['cpf']);
            return true;
        }
        return false;
    }
    //Atualizar
    public function atualizar(): bool
    {
        if (!$this->id) return false;
        $sql = "UPDATE clientes SET usuario_id = :usuario_id, telefone = :telefone, cpf = :cpf WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id);
        $cmd->bindValue(":usuario_id", $this->usuario_id);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);
        return $cmd->execute();
    }

    //Listar
    public static function listar(): array
    {
        $sql = "SELECT * FROM clientes";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Buscar Por Usuario
    public function buscarPorUsuario(int $usuario_id): bool
    {
        $sql = "SELECT * FROM clientes WHERE usuario_id = :usuario_id";
        $cmd = $this->pdo->prepare($sql);
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