<?php
$db = new SQLite3('../dados/imobiliaria.db');
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    die("Por favor, preencha todos os campos.");
}

// Buscar o utilizador pelo username
$stmt = $db->prepare('SELECT * FROM utilizadores WHERE username = ?');
$stmt->bindValue(1, $username);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if ($result && password_verify($password, $result['password'])) {
    $_SESSION['user'] = $result;

    // Atualiza o último acesso
    $update = $db->prepare('UPDATE utilizadores SET ultimo_acesso = datetime("now") WHERE id = ?');
    $update->bindValue(1, $result['id']);
    $update->execute();

    echo "Login com sucesso!";
} else {
    echo "Credenciais inválidas!";
}
?>