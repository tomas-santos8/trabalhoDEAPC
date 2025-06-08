-- Criar tabela principal de imóveis
CREATE TABLE imoveis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    localizacao TEXT NOT NULL,
    preco INTEGER NOT NULL,
    descricao TEXT,
    imagem TEXT
);

-- (Opcional) Criar tabela de propostas associadas a imóveis e compradores
CREATE TABLE propostas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    comprador_id INTEGER NOT NULL,
    imovel_id INTEGER NOT NULL,
    valor INTEGER NOT NULL,
    estado TEXT DEFAULT 'Em análise',
    FOREIGN KEY(imovel_id) REFERENCES imoveis(id)
);