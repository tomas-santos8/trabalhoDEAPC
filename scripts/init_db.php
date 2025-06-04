<?php
$db = new SQLite3('../dados/imobiliaria.db');

// Lê o conteúdo do SQL
$sql = file_get_contents('../dados/criar_base.sql');

if ($db->exec($sql)) {
    echo "Tabelas criadas com sucesso!";
} else {
    echo "Erro ao criar tabelas: " . $db->lastErrorMsg();
}
?>