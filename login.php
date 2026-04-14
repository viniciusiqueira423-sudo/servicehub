<?php
session_start(); //Iniciar a sessão ou atualizar a sessão aberta
include "includes/header.php";
include "includes/menu.php";

require "class/usuario.php";
// //Criar Objeto Usuario
// $user = new Usuario();
// //Chama o método efetuarLogin da classe Usuario
// var_dump($user->efetuarLogin('admin@servicehub.com', 'admin123'));

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
  $senha = $_POST["senha"] ?? null; //?? null operador de coalessência nula php.net: https://www.php.net/manual/pt_BR/migration70.new-features.php
  if (!$email || !$senha) {
    $msg = "Preencha os dados corretamente";
  }
  $usuario = Usuario::efetuarLogin($email, $senha);
  if (count($usuario) > 0) { //count conta elementos de um array
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];
    //Verificando primeiro login
    if ($usuario['primeiro_login'] == 1) {
      header('location: primeiro_login.php');
      exit;
    }
    if ($usuario['tipo'] == 1) {
      header('location: admin_dashboard.php');

    } else {
      header('location: cliente_dashboard.php');
    }
  }
}


// explicação de operador de coalescência nula (??) - se a variável for nula, atribui o valor do lado direito
// O operador de coalescência nula (??) foi adicionado como um truque sintático para o caso trivial de precisar usar
//  um ternário em conjunto com a função isset(). Ele retorna o primeiro operando se este existir e não for null; caso 
//  contrário retorna o segundo operando.

// <?php
// // Obtém o valor de $_GET['user'] e retorna 'nobody'
// // se ele não existir.
// $username = $_GET['user'] ?? 'nobody';
// // Isto equivale a:
// $username = isset($_GET['user']) ? $_GET['user'] : 'nobody';

// // A coalescência pode ser encadeada: isto irá retornar o primeiro
// // valor definido entre $_GET['user'], $_POST['user'] e
// // 'nobody'.
// $username = $_GET['user'] ?? $_POST['user'] ?? 'nobody';
// 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow p-4 col-md-5 mx-auto">
      <h3 class="text-center">Área Restrita</h3>


      <form method="POST">
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>

        <button class="btn btn-dark w-100">Entrar</button>
      </form>

      <p class="text-center mt-3">
        <a href="index.php">Voltar ao site</a>
      </p>
    </div>
  </div>
</body>

</html>
<?php
include "includes/footer.php";
?>