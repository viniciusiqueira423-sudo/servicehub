<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
require_once "config/conexao.php";
$nome = $_POST['txtnome'];
$cpf = $_POST['txtcpf'];
$email = $_POST['txtemail'];

$sql = "insert alunos (nome, cpf, email) values (:nome, :cpf, :email)";

$cmd = $pdo->prepare($sql);

$cmd->execute([ ":nome"=>$nome, ":cpf"=>$cpf, ":email"=>$email  ]);

$id = $pdo->lastInsertId();

if(isset($id)){
    echo "Aluno cadastrado com sucesso! Com o ID: $id";
}else{
    echo "Erro ao cadastrar aluno.";
}
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro de Alunos</title>
</head>
<body>
    <form class="form" action="formaluno.php" method="post">
        <input type="number" name="txtid" hidden>

        <label for="txtnome">Nome do Aluno:</label>
        <input type="text" name="txtnome">

        <label for="txtcpf">CPF:</label>
        <input type="text" name="txtcpf">

        <label for="txtemail">Email:</label>
        <input type="text" name="txtemail">

        <button class="btn btn-primary">Cadastrar</button>



    </form>
        <h2>Alunos</h2>
    <table border="1" cellpadding=10>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
        </tr>
        <?php foreach($alunos as $aluno): ?>
        <tr>
            <!-- short echo -->
            <td><?= $aluno['id'] ?></td>
            <td><?= $aluno['nome'] ?></td>
            <td><?= $aluno['cpf'] ?></td>
            <td><?= $aluno['email'] ?></td>

        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>