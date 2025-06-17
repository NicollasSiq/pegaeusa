<?php

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Busca a quantidade alugada
    $stmt = $conexao->prepare("SELECT quantidade FROM roupas WHERE id = ?");
    $stmt->execute([$id]);
    $roupa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($roupa) {
        $quantidadeDevolvida = intval($roupa['quantidade']);

        // Devolve tudo: quantidade volta para o estoque e status para 'disponivel'
        $stmt2 = $conexao->prepare("UPDATE roupas SET status = 'disponivel' WHERE id = ?");
        $ok = $stmt2->execute([$id]);

        if ($ok) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Erro ao devolver roupa.']);
        }
    } else {
        echo json_encode(['success' => false, 'msg' => 'Roupa não encontrada.']);
    }
    exit;
}
echo json_encode(['success' => false, 'msg' => 'Requisição inválida.']);