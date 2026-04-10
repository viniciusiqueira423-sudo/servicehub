<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
require_once "config/conexao.php";
$nome = $_POST['txtnome'];
$descricao = $_POST['txtdescricao'];
$preco = $_POST['txtpreco'];
// preparar o comando SQL para inserção dos dados
$sql = "insert servicos (nome, descricao, preco) values (:nome, :descricao, :preco)";
$cmd = $pdo->prepare($sql);
$cmd->execute([ ":nome"=>$nome, ":descricao"=>$descricao, ":preco"=>$preco]);
// recuperar o ID do registro recém-inserido
$id = $pdo->lastInsertId();

if(isset($id)){
    echo "Serviço cadastrado com sucesso! Com o ID: $id";
}else{
    echo "Erro ao cadastrar serviço.";
}
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro de Serviços</title>
</head>
<body>
    <form class="form" action="formservico.php" method="post">
        <input type="number" name="txtid" hidden>

        <label for="txtnome">Nome do Serviço:</label>
        <input type="text" name="txtnome">

        <label for="txtdescricao">Descrição:</label>
        <textarea type="text" name="txtdescricao"></textarea>

        <label for="txtpreco">Preço:</label>
        <input type="text" name="txtpreco">

        <button class="btn btn-primary">Gravar</button>

    </form>
</body>
</html>