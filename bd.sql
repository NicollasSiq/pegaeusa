-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL
);

-- Tabela de roupas
CREATE TABLE roupas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    quantidade INT NOT NULL,
    tipo VARCHAR(30) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    foto VARCHAR(255)
);

-- Tabela de aluguéis
CREATE TABLE alugueis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roupa_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_aluguel DATE NOT NULL,
    data_devolucao DATE,
    FOREIGN KEY (roupa_id) REFERENCES roupas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);