<?php
require_once 'conexao.php';
global $conexao;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $tamanho = $_POST['tamanho'];
    $quantidade = (int)$_POST['quantidade'];
    $tipo = $_POST['tipo'];
    $valor = (float)$_POST['valor'];

    $sql = "UPDATE roupas SET nome=?, tamanho=?, quantidade=?, tipo=?, valor=? WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$nome, $tamanho, $quantidade, $tipo, $valor, $id]);

    header("Location: ../index.php");
    exit;
}
?>