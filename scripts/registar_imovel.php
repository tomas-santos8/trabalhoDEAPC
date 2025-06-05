<?php
$db = new SQLite3('../db/imobiliaria.db');
$stmt = $db->prepare('INSERT INTO propriedades (titulo, preco, descricao) VALUES (?, ?, ?)');
$stmt->bindValue(1, $_POST['titulo']);
$stmt->bindValue(2, $_POST['preco']);
$stmt->bindValue(3, $_POST['descricao']);
$stmt->execute();
echo "Imóvel registado com sucesso!";
?>