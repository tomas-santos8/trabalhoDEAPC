-- Criação da base de dados
CREATE DATABASE IF NOT EXISTS imobiliaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE imobiliaria;

-- Criação da tabela imoveis
CREATE TABLE IF NOT EXISTS imoveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagem VARCHAR(255) NOT NULL,
    localizacao VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    propostas DECIMAL(10,2) NOT NULL,
    descricao TEXT NOT NULL
);

-- Inserção de imóveis de exemplo
INSERT INTO imoveis (imagem, localizacao, preco, propostas, descricao) VALUES
('../images2/casa1.jpg', 'Gaia', 450000, 400000, 'Moradia moderna com 3 quartos, 4 casas de banho, piscina, jardim, garagem, cozinha moderna e sala de estar luminosa.'),
('../images3/casa1.jpg', 'Lisboa', 450000, 440000, 'Casa de luxo perto do centro de Lisboa.');
