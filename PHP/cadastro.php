<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexao.php';

function exibirErro($msg) {
    echo "<script>alert('$msg');history.back();</script>";
    exit;
}

// $perfil pode vir como 'lojista' ou 'cliente' do formulário
$perfilForm = $_POST['perfil'] ?? '';

// Mapeia 'lojista' para 'admin' e 'cliente' para 'usuario'
if ($perfilForm === 'lojista') {
    $perfil = 'admin';
} elseif ($perfilForm === 'cliente') {
    $perfil = 'usuario';
} else {
    exibirErro('Perfil inválido! Escolha Lojista ou Cliente.');
}

$nome = trim($_POST['nome'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar_senha'] ?? '';
$senhaAdmin = $_POST['senha_admin'] ?? '';

// Validação básica
if (!$nome || !$usuario || !$senha || !$confirmar || !$perfilForm) {
    exibirErro('Preencha todos os campos!');
}
if ($senha !== $confirmar) {
    exibirErro('As senhas não coincidem!');
}
if (strlen($senha) < 6) {
    exibirErro('A senha deve ter pelo menos 6 caracteres.');
}

// Se for lojista (admin), exige senha especial
if ($perfilForm === 'lojista' && $senhaAdmin !== 'Senai2DA@2025#7') {
    exibirErro('Senha de administrador incorreta!');
}

try {
    $conn = conectarBD();

    // Verifica se o usuário já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    if ($stmt->fetch()) {
        exibirErro('Usuário já cadastrado!');
    }

    // Criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o usuário com perfil já convertido para 'admin' ou 'usuario'
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, usuario, senha, perfil) VALUES (?, ?, ?, ?)");
    $ok = $stmt->execute([$nome, $usuario, $senhaHash, $perfil]);

    if ($ok) {
        header("Location: ../login.html");
        exit;
    } else {
        $erro = $stmt->errorInfo();
        exibirErro('Erro ao criar conta: ' . $erro[2]);
    }
} catch (Exception $e) {
    exibirErro('Erro no servidor: ' . $e->getMessage());
}