<?php
require_once 'conexao.php';

class Auth {

    // Autentica usuário e retorna dados ou false
    public static function autenticar($usuario, $senha) {
        $conn = conectarBD();
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $conn->prepare($query);
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            return [
                'id' => $user['id'],
                'nome' => $user['nome'],
                'usuario' => $user['usuario'],
                'perfil' => $user['perfil']
            ];
        }
        return false;
    }

    // Inicia sessão e armazena dados do usuário
    public static function iniciarSessao($usuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['auth'] = [
            'logado' => true,
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'usuario' => $usuario['usuario'],
            'perfil' => $usuario['perfil']
        ];
    }

    // Encerra sessão
    public static function encerrarSessao() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    }

    // Verifica se está logado
    public static function estaLogado() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['auth']) && $_SESSION['auth']['logado'] === true;
    }

    // Retorna dados do usuário logado
    public static function obterUsuario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['auth'] ?? null;
    }

    // Verifica perfil
    public static function temPerfil($perfil) {
        $usuario = self::obterUsuario();
        return $usuario && $usuario['perfil'] === $perfil;
    }

    // Verifica permissão para ação
    public static function temPermissao($acao) {
        $usuario = self::obterUsuario();
        if (!$usuario) return false;
        $permissoes = [
            'admin' => [
                'visualizar' => true,
                'adicionar' => true,
                'editar' => true,
                'excluir' => true
            ],
            'usuario' => [
                'visualizar' => true,
                'adicionar' => false,
                'editar' => false,
                'excluir' => false
            ],
        ];
        return $permissoes[$usuario['perfil']][$acao] ?? false;
    }
}