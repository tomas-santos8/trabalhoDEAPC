CREATE TABLE IF NOT EXISTS utilizadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    tipo TEXT,
    ultimo_acesso TEXT
);

CREATE TABLE IF NOT EXISTS imoveis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT,
    descricao TEXT,
    preco REAL,
    localizacao TEXT,
    estado TEXT DEFAULT 'pendente',
    id_vendedor INTEGER,
    id_agente INTEGER,
    FOREIGN KEY(id_vendedor) REFERENCES utilizadores(id),
    FOREIGN KEY(id_agente) REFERENCES utilizadores(id)
);

CREATE TABLE IF NOT EXISTS propostas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    imovel_id INTEGER,
    comprador_id INTEGER,
    mensagem TEXT,
    valor REAL,
    estado TEXT DEFAULT 'pendente',
    FOREIGN KEY(imovel_id) REFERENCES imoveis(id),
    FOREIGN KEY(comprador_id) REFERENCES utilizadores(id)
);

CREATE TABLE IF NOT EXISTS mensagens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    de_id INTEGER,
    para_id INTEGER,
    conteudo TEXT,
    data TEXT,
    FOREIGN KEY(de_id) REFERENCES utilizadores(id),
    FOREIGN KEY(para_id) REFERENCES utilizadores(id)
);