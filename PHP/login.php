<?php
$db = new SQLite3('../dados/imobiliaria.db');
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $db->prepare('SELECT * FROM utilizadores WHERE username = ? AND password = ?');
$stmt->bindValue(1, $username);
$stmt->bindValue(2, $password);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if ($result) {
    $_SESSION['user'] = $result;
    echo "Login com sucesso!";
} else {
    echo "Credenciais inválidas!";
}
?>