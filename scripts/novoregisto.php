<?php
// Script para registar novo utilizador

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($username) || empty($password)) {
        die("Por favor, preencha todos os campos.");
    }

    // Abrir ou criar a base de dados
    $db = new SQLite3(__DIR__ . '/../dados/app.db');

    // Criar a tabela se ainda não existir
    $db->exec("CREATE TABLE IF NOT EXISTS utilizadores (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT,
        ultimo_acesso TEXT
    )");

    // Verificar se já existe
    $stmt = $db->prepare("SELECT * FROM utilizadores WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        echo "Este utilizador já existe!";
    } else {
        $stmt = $db->prepare("INSERT INTO utilizadores (username, password) VALUES (:username, :password)");
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();

        echo "Utilizador registado com sucesso!";
    }
}
?>
