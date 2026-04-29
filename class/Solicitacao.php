<?php
//incluir conexão
include_once "config/conexao.php";

class Solicitacao
{
    private $id;
    private $cliente_id;
    private $descricao_problema;
    private $data_preferida;
    private $status;
    private $data_cad;
    private $data_atualizacao;
    private $data_resposta;
    private $resposta_admin;
    private $endereco;
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
    //Cliente
    public function setClienteId(int $cliente_id)
    {
        return $this->cliente_id = $cliente_id;
    }
    //Descrição do Problema
    public function setDescricaoProblema(string $descricao_problema)
    {
        return $this->descricao_problema = $descricao_problema;
    }
    //Data Preferida
    public function setDataPreferida($data_preferida)
    {
        return $this->data_preferida = $data_preferida;
    }
    // endereco
    public function setEndereco(string $endereco)
    {
        return $this->endereco = $endereco;
    }

    //Métodos obrigatórios:
    //Inserir
    public function inserir(): bool
    {
        $sql = "INSERT into solicitacoes (cliente_id, descricao_problema, data_preferida, status, endereco) values(:cliente_id, :descricao, :data_preferida, 1, :endereco)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cliente_id", $this->cliente_id, PDO::PARAM_INT);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":endereco", $this->endereco);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();;
            return true;
        }
        return false;
    }
    //Listar
    public static function listar(): array
    {
        $sql = "select * from solicitacoes ORDER BY data_cad DESC";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Listar Por Cliente
    public static function listarPorCliente(int $cliente_id): array
    {
        $sql = "select * from solicitacoes where cliente_id = :cliente_id ORDER BY data_cad DESC";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar Por Id
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);

            $this->id = $dados['id'];
            $this->cliente_id = $dados['cliente_id'];
            $this->descricao_problema = $dados['descricao_problema'];
            $this->data_preferida = $dados['data_preferida'];
            $this->status = $dados['status'];
            $this->data_cad = $dados['data_cad'];
            $this->data_atualizacao = $dados['data_atualizacao'];
            $this->data_resposta = $dados['data_resposta'];
            $this->resposta_admin = $dados['resposta_admin'];
            $this->endereco = $dados['endereco'];
            return true;
        }
        return false;
    }

    //Responder
    public function responder(string $resposta, int $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes SET resposta_admin = :resposta, status = :status, data_resposta = NOW(), data_atualizacao = NOW() WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":resposta", $resposta);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    //Atualizar Status
    public function atualizarStatus(int $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes SET status = :status, data_atualizacao = NOW() WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}