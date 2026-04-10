<?php
include_once "config/conexao.php";


$sql = "select * from servicos";
$cmd = $pdo->prepare($sql);
    $cmd->execute();
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);
                                                                                 
// tabela de usuarios
$sql = "select * from usuarios";                              
$cmd = $pdo->prepare($sql);
$cmd->execute();
$usuarios = $cmd->fetchAll(PDO::FETCH_ASSOC);

// tabela de clientes
$sql = "select * from clientes";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$clientes = $cmd->fetchAll(PDO::FETCH_ASSOC);
// var_dump($servicos); 
// var_dump($usuarios);
// var_dump($clientes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula PDO PHP</title>
</head>
<body>
        <form action="resform.php" method="post">
        <input type="text" name="txtid" id="">
        <button type="submit">Enviar</button>
    </form>
    <h2>Serviços</h2>
    <table border="1" cellpadding=10>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Descontinuado</th>
        </tr>
        <?php foreach($servicos as $servico):?>
        <tr>
            <!-- short echo -->
            <td><?= $servico['id'] ?></td>
            <td><?= $servico['nome'] ?></td>
            <td><?= $servico['descricao'] ?></td>
            <td><?= $servico['preco'] ?></td>
            <td><?= $servico['descontinuado'] ? 'Sim' : 'Não' ?></td>
        <?php endforeach; ?>
        </tr>
    </table>
    <h2>Usuários</h2>
    <table border="1" cellpadding=10>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha Criptografada</th>
            <th>Nivel</th>
            <th>Ativo</th>
        </tr>
        <?php foreach($usuarios as $usuario):?>
        <tr>
            <!-- short echo -->
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['nome'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['senha'] ?></td>
            <td><?= $usuario['tipo'] ? 'Administrador' : 'Usuário' ?></td>
            <td><?= $usuario['ativo'] ? 'Sim' : 'Não' ?></td>
        <?php endforeach; ?>
        </tr>
    </table>
    <h2>Clientes</h2>
    <table border="1" cellpadding=10>
        <tr>
            <th>id</th>
            <th>id_usuario</th>
            <th>telefone</th>
            <th>cpf</th>
        </tr>
        <?php foreach($clientes as $cliente):?>
        <tr>
            <!-- short echo -->
            <td><?= $cliente['id'] ?></td>
            <td><?= $cliente['id_usuario'] ?></td>
            <td><?= $cliente['telefone'] ?></td>
            <td><?= $cliente['cpf'] ?></td>
        <?php endforeach; ?>
        </tr>
    </table>

</body>
</html>