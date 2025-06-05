-- Tabela de Utilizadores
CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,  -- ou AUTO_INCREMENT conforme o SGBD
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    telefone TEXT,
    endereco TEXT,
    role TEXT NOT NULL CHECK( role IN ('dono', 'agente', 'comprador') )
);
