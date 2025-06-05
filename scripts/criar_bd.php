<?php
$db = new SQLite3('../dados/imobiliaria.db');

$db->exec("CREATE TABLE IF NOT EXISTS utilizadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    tipo TEXT,
    ultimo_acesso TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS imoveis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dono_id INTEGER,
    titulo TEXT,
    descricao TEXT,
    preco REAL,
    publicado BOOLEAN DEFAULT 0,
    FOREIGN KEY (dono_id) REFERENCES utilizadores(id)
)");

$db->exec("CREATE TABLE IF NOT EXISTS propostas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    imovel_id INTEGER,
    comprador_id INTEGER,
    mensagem TEXT,
    valor REAL,
    estado TEXT,
    FOREIGN KEY (imovel_id) REFERENCES imoveis(id),
    FOREIGN KEY (comprador_id) REFERENCES utilizadores(id)
)");

$db->exec("CREATE TABLE IF NOT EXISTS mensagens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    de_id INTEGER,
    para_id INTEGER,
    conteudo TEXT,
    data TEXT,
    FOREIGN KEY (de_id) REFERENCES utilizadores(id),
    FOREIGN KEY (para_id) REFERENCES utilizadores(id)
)");

echo "Base de dados criada com sucesso!";
?>