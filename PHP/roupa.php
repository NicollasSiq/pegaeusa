<?php
require_once 'conexao.php'; // Arquivo da conexão com o banco
global $conexao;

// Definindo a classe Roupa
class Roupa {
    private $id;
    private $nome;
    private $tamanho;
    private $preco; 
    private $quantidade;
    private $tipo;
    private $status;

    public function __construct(int $id, string $nome, string $tamanho, float $preco, int $quantidade, string $tipo, string $status) {
        $this->id = $id;
        $this->nome = $nome;
        $this->tamanho = $tamanho;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->tipo = $tipo;
        $this->status = $status;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getTamanho() { return $this->tamanho; }
    public function getPreco() { return $this->preco; }
    public function getQuantidade() { return $this->quantidade; }
    public function getTipo() { return $this->tipo; }
    public function getStatus() { return $this->status; }
}

// Código para buscar do banco e guardar em objetos Roupa
try {
    $sql = "SELECT id, nome, tamanho, valor, quantidade, tipo, status FROM roupas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $roupas = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $roupa = new Roupa(
            $row['id'],
            $row['nome'],
            $row['tamanho'],
            $row['valor'],
            $row['quantidade'],
            $row['tipo'],
            $row['status']
        );
        $roupas[] = $roupa;
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>