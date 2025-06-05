-- SQLite
CREATE TABLE IF NOT EXISTS utilizadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    tipo TEXT NOT NULL,           -- 'dono', 'comprador', ou 'agente'
    nome TEXT,
    email TEXT,
    ultimo_acesso DATETIME
);