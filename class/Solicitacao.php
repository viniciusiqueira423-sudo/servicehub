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
    public function getClienteId()
    {
        return $this->cliente_id;
    }
    public function setClienteId(int $cliente_id)
    {
        return $this->cliente_id = $cliente_id;
    }

    //Descrição do Problema
    public function getDescricaoProblema()
    {
        return $this->descricao_problema;
    }
    public function setDescricaoProblema(string $descricao_problema)
    {
        return $this->descricao_problema = $descricao_problema;
    }

    //Data Preferida
    public function getDataPreferida()
    {
        return $this->data_preferida;
    }
    public function setDataPreferida(int $data_preferida)
    {
        return $this->data_preferida = $data_preferida;
    }

    //status
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus(bool $status)
    {
        return $this->status = $status;
    }

    //data_cad
    public function getDataCadastro()
    {
        return $this->data_cad;
    }
    public function setDataCadastro(int $data_cad)
    {
        return $this->data_cad = $data_cad;
    }

    //data_atualizacao
    public function getDataAtualizacao()
    {
        return $this->data_atualizacao;
    }
    public function setDataAtualizacao(int $data_atualizacao)
    {
        return $this->data_atualizacao = $data_atualizacao;
    }

    // data_resposta
    public function getDataResposta()
    {
        return $this->data_resposta;
    }
    public function setDataResposta(int $data_resposta)
    {
        return $this->data_resposta = $data_resposta;
    }

    // resposta_admin
    public function getRespostaAdmin()
    {
        return $this->resposta_admin;
    }
    public function setRespostaAdmin(string $resposta_admin)
    {
        return $this->resposta_admin = $resposta_admin;
    }

    // endereco
    public function getEndereco()
    {
        return $this->endereco;
    }
    public function setEndereco(string $endereco)
    {
        return $this->endereco = $endereco;
    }


    //Métodos obrigatórios:
    //Inserir
    public function inserir(): bool
    {
        $sql = "INSERT into solicitacoes (cliente_id, descricao_problema, data_preferida, status, data_cad, data_atualizacao, data_resposta, resposta_admin, endereco) values(:cliente_id, :descricao_problema, :data_preferida, 1, :data_cad, :data_atualizacao, :data_resposta, :resposta_admin, :endereco)";
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
        $sql = "select * from solicitacoes";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }
    //Listar Por Cliente
    public static function listarPorCliente(): array
    {
        $sql = "select * from solicitacoes where cliente_id = :cliente_id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }

    //Buscar Por Id
        public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
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
    //Atualizar Status
}