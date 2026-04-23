<?php
// incluir a conexão
include_once "config/conexao.php";
//lista do que precisa ser feito para o serviço:
// id
// nome
// descricao
// preco
// descontinuado

// Métodos obrigatórios:
// inserir(): bool
// atualizar(): bool
// listar(): array
// listarAtivos(): array
// buscarPorId(int $id): bool
// excluir(int $id): bool (pode ser exclusão lógica usando descontinuado)


// declara a classe
class Servico
{
    //atributos
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $descontinuado;
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
    //nome
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }
    //descricao
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
    }
    //preco
    public function getPreco()
    {
        return $this->preco;
    }
    public function setPreco(float $preco)
    {
        $this->preco = $preco;
    }
    //descontinuado
    public function getDescontinuado()
    {
        return $this->descontinuado;
    }
    public function setDescontinuado(bool $descontinuado)
    {
        $this->descontinuado = $descontinuado;
    }
    //métodos obrigatórios - Representam os RFs do projeto
    //Lista de métodos a serem implementados:
    /*
    inserir(): bool
    atualizar(): bool
    listar(): array
    listarAtivos(): array
    buscarPorId(int $id): bool
    excluir(int $id): bool (pode ser exclusão lógica usando descontinuado)
    */
    // inserir
    public function inserir(): bool
    {
        if (empty($this->nome) || empty($this->preco)) {
            return false;
        }

        $sql = "INSERT INTO servicos (nome, descricao, preco, descontinuado) VALUES (:nome, :descricao, :preco, :descontinuado)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);
        $cmd->bindValue(":descontinuado", (int)$this->descontinuado, PDO::PARAM_INT);
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
        $sql = "UPDATE servicos SET nome = :nome, descricao = :descricao, preco = :preco, descontinuado = :descontinuado WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);
        $cmd->bindValue(":descontinuado", $this->descontinuado, PDO::PARAM_BOOL);
        $cmd->bindValue(":id", $this->id);
        return $cmd->execute();
    }
    //listar
    public static function listar(): array
    {
        $sql = "SELECT * FROM servicos";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
    //listarAtivos
    public static function listarAtivos(): array
    {
        $sql = "SELECT * FROM servicos WHERE descontinuado = 0";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
    //Buscar por id
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM servicos WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $this->id = $dados['id'];
            $this->nome = $dados['nome'];
            $this->descricao = $dados['descricao'];
            $this->preco = $dados['preco'];
            $this->descontinuado = $dados['descontinuado'];
            return true;
        }
        return false;
    }
    //excluir (exclusão lógica usando descontinuado)
public function excluir(): bool
{
    if (empty($this->id)) {
        return false;
    }

    $sql = "UPDATE servicos SET descontinuado = 1 WHERE id = :id AND descontinuado = 0";

    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":id", $this->id);
    $cmd->execute();

    return $cmd->rowCount() > 0;
}
}
