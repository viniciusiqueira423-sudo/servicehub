<?php 
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