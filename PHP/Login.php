<?php
session_start();
require_once 'conexao.php';

function exibirErro($msg) {
    echo "<script>alert('$msg');history.back();</script>";
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!$usuario || !$senha) {
    exibirErro('Preencha todos os campos!');
}

try {
    $conn = conectarBD();

    $stmt = $conn->prepare("SELECT id, nome, usuario, senha, perfil FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($senha, $user['senha'])) {
        exibirErro('Usuário ou senha inválidos!');
    }

    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_nome'] = $user['nome'];
    $_SESSION['usuario_perfil'] = $user['perfil'];

    header("Location: ../aluguel.html");
    exit;
} catch (Exception $e) {
    exibirErro('Erro no servidor: ' . $e->getMessage());
}