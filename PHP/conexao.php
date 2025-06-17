<?php
/**
 * Função para conectar com o banco de dados de forma segura usando PDO.
 */
function conectarBD() {
    // Endereço do servidor do banco de dados
    $host = 'localhost';
    // Nome do banco de dados
    $dbname = 'pegaeusa';
    // Usuário do banco de dados
    $user = 'root';
    // Senha do banco de dados
    $pass = '';

    try {
        // Cria uma nova conexão PDO com charset seguro (utf8mb4)
        $conn = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4", // DSN de conexão
            $user, // Usuário
            $pass, // Senha
            [
                PDO::ATTR_EMULATE_PREPARES => false, // Garante uso de prepared statements reais
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retorna resultados como array associativo
            ]
        );
        // Retorna o objeto de conexão PDO
        return $conn;
    } catch (PDOException $e) {
        // Em caso de erro, encerra o script e exibe mensagem segura
        die("Erro ao conectar ao banco de dados.");
        // Para debug, use: die("Erro: " . $e->getMessage());
    }
}

$conexao = conectarBD();