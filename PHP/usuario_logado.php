<?php
// usuario_logado.php
require_once 'Auth.php';
header('Content-Type: application/json');
if (Auth::estaLogado()) {
    $usuario = Auth::obterUsuario();
    echo json_encode(['perfil' => $usuario['perfil']]);
} else {
    echo json_encode(['perfil' => 'usuario']);
}