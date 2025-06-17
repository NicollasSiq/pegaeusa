<?php
require_once 'conexao.php';
global $conexao;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $tamanho = $_POST['tamanho'] ?? '';
    $quantidade = (int)($_POST['quantidade'] ?? 0);
    $tipo = $_POST['tipo'] ?? '';
    $valor = (float)($_POST['valor'] ?? 0);
    $status = 'disponivel';

    // Foto (opcional)
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoNome = uniqid() . '_' . basename($_FILES['foto']['name']);
        $destino = '../Imagens/' . $fotoNome;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $foto = $fotoNome;
        }
    }

    $sql = "INSERT INTO roupas (nome, tamanho, quantidade, tipo, valor, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$nome, $tamanho, $quantidade, $tipo, $valor, $status, $foto]);

    header("Location: ../index.php");
    exit;
}
?>