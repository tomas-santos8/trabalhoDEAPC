<?php
// Criar/abrir a base de dados
$db = new SQLite3('../BD/BdImobiliaria.db'); // Ajusta o caminho conforme necessário

// Criar tabela de utilizadores
$db->exec("CREATE TABLE IF NOT EXISTS utilizadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    nome TEXT,
    email TEXT,
    ultimo_acesso DATETIME
)");

// Criar tabela de imóveis
$db->exec("CREATE TABLE IF NOT EXISTS imoveis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tipo TEXT,
    localizacao TEXT,
    preco REAL,
    estado TEXT,
    descricao TEXT
)");

// Criar tabela de clientes
$db->exec("CREATE TABLE IF NOT EXISTS clientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    contacto TEXT,
    email TEXT
)");

// Criar tabela de contratos
$db->exec("CREATE TABLE IF NOT EXISTS contratos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_cliente INTEGER,
    id_imovel INTEGER,
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY(id_cliente) REFERENCES clientes(id),
    FOREIGN KEY(id_imovel) REFERENCES imoveis(id)
)");

// Criar tabela de acessos
$db->exec("CREATE TABLE IF NOT EXISTS acessos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_utilizador INTEGER,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(id_utilizador) REFERENCES utilizadores(id)
)");

echo "Base de dados criada com sucesso!";
?>
