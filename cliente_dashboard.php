<?php
//inicia a sessão para permitir o uso de $_SESSION e controle de acesso
session_start();

//inclui o header e o menu para manter a consistência visual do site
include "includes/header.php";
include "includes/menu.php";

//inclui o arquivo de conexão com o banco de dados
require_once "config/conexao.php";

//inclui as funcoes auxiliares do sistema
require_once "includes/funcoes.php";

//classe Cliente para manipular os dados do cliente logado
require_once "class/Cliente.php";


//verifica se o usuário está logado e se é do tipo cliente (tipo 2)
if (!isset($_SESSION['usuario_id']) || $_SESSION["tipo"] != 2) {
  header("location: login.php");
}

//cria um objeto da classe Cliente
$cliente = new Cliente;

//busca os dados do cliente logado usando o ID armazenado na sessão
if (!$cliente->buscarPorId($_SESSION['usuario_id'])) {
  //se o cliente não for encontrado, encerra
  die("Cliente não encontrado.");
}

//consulta SQL para buscar as solicitações do cliente logado
//tambem busca os serviços vinculados a cada solicitação
$sql = "SELECT s.id, s.status, s.data_cad, GROUP_CONCAT(se.nome SEPARATOR ', ') AS servicos FROM solicitacoes s
        INNER JOIN servico_solicitacao ss ON ss.solicitacoes_id = s.id
        INNER JOIN servicos se ON se.id = ss.servico_id
        WHERE s.cliente_id=?
        GROUP BY s.id, s.status, s.data_cad
        ORDER BY s.data_cad DESC";

//prepara a consulta
$cmd = obterPdo()->prepare($sql);

//executa 
$cmd->execute([$cliente->getId()]);

//busca todas as solicitações encontradas no banco
$solicitacoes = $cmd->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="container mt-5">
  <h2>Bem-vindo, <strong><?= $_SESSION['nome'] ?></strong></h2>
  <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
  <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>
  <h4 class="mt-4">Minhas Solicitações</h4>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($solicitacoes as $s): ?>
        <tr>

          <td><?= $s["id"] ?></td>

          <!-- SERVIÇOS -->
          <td>
            <?php
            $lista = explode(", ", $s["servicos"]);
            foreach ($lista as $nomeServico) {
              echo '<span class="badge bg-primary me-1 mb-1">' . htmlspecialchars($nomeServico) . '</span>';
            }
            ?>
          </td>

          <!-- STATUS -->
          <td><?= statusTexto($s["status"]) ?></td>

          <!-- DATA -->
          <td><?= date("d/m/Y H:i", strtotime($s["data_cad"])) ?></td>

          <!-- AÇÃO -->
          <td>
            <a href="cliente_detalhes.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">
              Detalhes
            </a>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php
include "includes/footer.php";
?>