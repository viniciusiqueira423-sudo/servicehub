<?php
session_start();

require_once "class/Cliente.php";
require_once "class/Solicitacao.php";
require_once "class/Servico.php";
require_once "class/ServicoSolicitacao.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: contratar.php?error=Invalid Request.");
    exit();
}

//verificação de segurança (se quem esta logado tem o direito de acessar essa página)
//csrf

$token = $_POST['csrf_token'] ?? "";
if (!$token || isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    header("location: contratar.php?erro=Invalid CSRF token.");
    exit();
}
// inputs (são os campos do formulário)
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize_full_special_chars é um filtro que remove caracteres especiais e previne ataques de XSS
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); //validate_email é um filtro que valida se o email é válido, se não for retorna false
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$endereco = filter_input(INPUT_POST, 'endereco', FILTER_UNSAFE_RAW); //unsafe_raw é um filtro que não faz nenhuma sanitização, ou seja, aceita qualquer coisa, é usado quando queremos permitir caracteres especiais, como no caso do endereço
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW);

$data_preferida = filter_input(INPUT_POST, 'data_preferida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? ""); // Remove tudo que não for número quando o campo CPF for preenchido
$servicos_ids = $_POST['servicos_id'] ?? []; // array de servicos

//validação dos serviços
if (!is_array($servicos_ids)) {
    header("location: contratar.php?erro=Selecione ao menos um serviço.");
    exit();
}
$servicos_validos = [];
foreach ($servicos_ids as $id) {
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $servicos_validos[] = $id;
}
//validações gerais
if (!$nome || strlen($nome) < 3) {
    header("location: contratar.php?erro=Nome invalido.");
    exit();
}
if (!$email) {
    header("location: contratar.php?erro=Email invalido.");
    exit();
}
if (!$telefone || strlen($telefone) < 8) {
    header("location: contratar.php?erro=Telefone invalido.");
    exit();
}
if (!$endereco || strlen($endereco) < 5) {
    header("location: contratar.php?erro=Endereço invalido.");
    exit();
}
if (!$descricao || strlen($descricao) < 10) {
    header("location: contratar.php?erro=Descreva melhor o problema(min 10 caracteres).");
    exit();
}
if (!$cpf && strlen($cpf) !== 11) {
    header("location: contratar.php?erro=CPF invalido.");
    exit();
}
if (count($servicos_validos) < 1) {
    header("location: contratar.php?erro=Selecione ao menos um serviço.");
    exit();
}
if ($data_preferida) {
    $ts = strtotime($data_preferida);
    if ($ts === false) {
        header("location: contratar.php?erro=Data preferida invalida.");
        exit();
    }
    if ($ts < strtotime(date("Y-m-d"))) {
        header("location: contratar.php?erro= A data não pode serr anterior à data atual.");
        exit();
    }
}
//Verificar se o usuario existe
$usuarioBanco = new Usuario();
if ($usuarioBanco->buscarPorEmail($email) == false) {
    // se retornou falso, é por que não existe usuario com este email, então podemos criar um novo cliente
    $usuario = new Usuario();
    $usuario->setNome($nome);
    $usuario->setEmail($email);
    $usuario->setSenha("123456");
    $usuario->setTipo(2);
    $usuario->setAtivo(true);
    $usuario->setPrimeiroLogin(true);
    if (!$usuario->inserir()) {
        header("location: contratar.php?erro=Erro ao cadastrar usuário.");
        exit();
    }

    $usuario_id = $usuario->getId();
} else {
    // se retornou true, é por que já existe um usuario com este email, então vamos usar o id deste usuario para criar a solicitação
    $usuario_id = $usuarioBanco->getId();
}
//verifica se o cliente existe, se não existir, cria um novo cliente
$cliente = new Cliente();
if ($cliente->buscarPorUsuario($usuario_id) == false) {
    // gravamos o cliente
    $cliente->setUsuarioId($usuario_id);
    $cliente->setTelefone($telefone);
    $cliente->setCpf($cpf);
    if (!$cliente->inserir()) {
        header("location: contratar.php?erro=Erro ao cadastrar cliente.");
        exit();
    }
}
$cliente_id = $cliente->getId();
// Cadastrar a solicitação
$solicitacao = new Solicitacao();
$solicitacao->setClienteId($cliente_id);
$solicitacao->setDescricaoProblema($descricao);
$solicitacao->setDataPreferida($data_preferida ?: null);
$solicitacao->setEndereco($endereco);

if (!$solicitacao->inserir()) {
    header("location: contratar.php?erro=Erro ao cadastrar solicitação.");
    exit();
}
$solicitacao_id = $solicitacao->getId();
//associar os serviços à solicitação