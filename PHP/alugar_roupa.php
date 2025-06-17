<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $dias = intval($_POST['dias']);
    $quantidade = intval($_POST['quantidade']);

    $stmt = $conexao->prepare("SELECT * FROM roupas WHERE id = ?");
    $stmt->execute([$id]);
    $roupa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        $roupa &&
        strtolower(trim($roupa['status'])) === 'disponivel' &&
        intval($roupa['quantidade']) >= $quantidade &&
        $quantidade > 0 &&
        $dias > 0
    ) {
        $novaQuantidade = intval($roupa['quantidade']) - $quantidade;
        $valor = floatval(str_replace(',', '.', $roupa['preco']));
        $total = $dias * $valor * $quantidade;

        $novoStatus = $novaQuantidade == 0 ? 'alugado' : 'disponivel';
        $stmt2 = $conexao->prepare("UPDATE roupas SET quantidade=?, status=? WHERE id=?");
        $stmt2->execute([$novaQuantidade, $novoStatus, $id]);

        echo json_encode([
            'success' => true,
            'total' => $total,
            'quantidade' => $novaQuantidade,
            'status' => $novoStatus
        ]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Roupa não disponível ou dados inválidos.']);
    }
    exit;
}
echo json_encode(['success' => false, 'msg' => 'Requisição inválida.']);