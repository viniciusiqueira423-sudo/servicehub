<?php
include_once "config/conexao.php";

class ServicoSolicitacao
{
    private $servico_id;
    private $solicitacao_id;
    private $data_assoc;
    private $pdo;

    //contrutor
    public function __construct()
    {
        $this->pdo = obterPdo();
    }
    //Getters e Setters
    //Servico Id
    public function getServicoId()
    {
        return $this->servico_id;
    }
    public function setServicoId(int $servico_id)
    {
        $this->servico_id = $servico_id;
    }

    //Solicitação Id 
    public function getSolicitacaoId()
    {
        return $this->solicitacao_id;
    }
    public function setSolicitacaoId(int $solicitacao_id)
    {
        $this->solicitacao_id = $solicitacao_id;
    }

    //Data Associação
    public function getDataAssoc()
    {
        return $this->data_assoc;
    }
    public static function associar(int $servico_id, int $solicitacao_id): bool{
        $sql = "insert servico_solicitacao value(: servico_id, solicitacao_id, default)";
        $cmd = obterPdo()->prepare($sql);
        $cmd -> bindValue(":servico_id", $servico_id);
        $cmd -> bindValue(":solicitacao_id", $solicitacao_id);
        return $cmd->execute();
    }
    public static function listarServicosDaSolicitacao(int $solicitacao_id): array{
        $sql = "SELECT se.*, ss.data_assoc FROM servicos se ON se.id = ss.servico_id WHERE ss.solicitacao_id = :solicitacao_id";
        $cmd = obterPdo()->prepare($sql);
        $cmd -> bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
        $cmd -> execute();
        return $cmd -> fetchAll(PDO::FETCH_ASSOC);
    }
}