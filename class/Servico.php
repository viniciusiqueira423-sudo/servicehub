<?php
//incluir conexão
include_once "config/conexao.php";
//declara classe
class Servico
{
    //atributos
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $descontinuado;
    private $pdo;
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

    //Nome
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }
    //DESCRIÇÃO
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao(string $descricao)
    {
        return $this->descricao = $descricao;
    }
    //PREÇO
    public function getPreco()
    {
        return $this->preco;
    }
    public function setPreco(float $preco)
    {
        return $this->preco = $preco;
    }
    //DESCONTINUADO
    public function getDescontinuado()
    {
        return $this->descontinuado;
    }
    public function setDescontinuado(bool $descontinuado)
    {
        return $this->descontinuado = $descontinuado;
    }

    //Métodos Obrigatórios
    //Inserir
    public function inserir(): bool
    {
        $sql = "INSERT into servicos (nome, descricao, preco, descontinuado) values(:nome, :descricao, :preco, :descontinuado)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);
        $cmd->bindValue(":descontinuado", $this->descontinuado);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();;
            return true;
        }
        return false;
    }
    //Buscar por ID
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM servicos WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            $this->id = $dados['id'];
            $this->setNome($dados['nome']);
            $this->setDescricao($dados['descricao']);
            $this->setPreco($dados['preco']);
            $this->setDescontinuado($dados['descontinuado']);
            return true;
        }
        return false;
    }
    //Atualizar
    public function atualizar(): bool
    {
        if (!$this->id) return false;
        $sql = "UPDATE servicos SET nome = :nome, descricao = :descricao, preco = :preco, descontinuado = :descontinuado WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);
        $cmd->bindValue(":descontinuado", $this->descontinuado);
        return $cmd->execute();
    }

    //Listar
    public static function listar(): array
    {
        $sql = "SELECT * FROM servicos";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Listar Ativos
    public static function listarAtivos(): array
    {
        $sql = "SELECT * FROM servicos WHERE descontinuado = 0";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Excluir
        public function excluir():bool{
        $sql = "UPDATE servicos SET descontinuado = :descontinuado WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id",$this->id);
        $cmd->bindValue(":descontinuado",$this->descontinuado, PDO::PARAM_BOOL);
        return $cmd->execute();
        }
}