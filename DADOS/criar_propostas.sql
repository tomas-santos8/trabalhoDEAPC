CREATE TABLE IF NOT EXISTS propostas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    comprador_id INTEGER NOT NULL,
    imovel_id INTEGER NOT NULL,
    valor INTEGER NOT NULL,
    estado TEXT DEFAULT 'Em análise',
    data_proposta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(imovel_id) REFERENCES imoveis(id)
);