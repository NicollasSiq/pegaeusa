<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $stmt = $conexao->prepare("DELETE FROM roupas WHERE id = ?");
    $ok = $stmt->execute([$id]);
    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Erro ao excluir roupa.']);
    }
    exit;
}
echo json_encode(['success' => false, 'msg' => 'Requisição inválida.']);