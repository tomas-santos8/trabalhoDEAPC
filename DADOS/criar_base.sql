CREATE TABLE IF NOT EXISTS utilizadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    tipo TEXT NOT NULL,
    nome TEXT,
    email TEXT,
    ultimo_acesso DATETIME
);

CREATE TABLE IF NOT EXISTS imoveis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    descricao TEXT,
    preco REAL NOT NULL,
    localizacao TEXT,
    estado TEXT DEFAULT 'pendente',
    id_vendedor INTEGER,
    id_agente INTEGER,
    FOREIGN KEY(id_vendedor) REFERENCES utilizadores(id),
    FOREIGN KEY(id_agente) REFERENCES utilizadores(id)
);

CREATE TABLE IF NOT EXISTS propostas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_comprador INTEGER,
    id_imovel INTEGER,
    valor REAL NOT NULL,
    estado TEXT DEFAULT 'pendente',
    data_submissao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(id_comprador) REFERENCES utilizadores(id),
    FOREIGN KEY(id_imovel) REFERENCES imoveis(id)
);

CREATE TABLE IF NOT EXISTS mensagens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    remetente_id INTEGER,
    destinatario_id INTEGER,
    texto TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(remetente_id) REFERENCES utilizadores(id),
    FOREIGN KEY(destinatario_id) REFERENCES utilizadores(id)
);