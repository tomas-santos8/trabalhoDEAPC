<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $tipo = $_POST["tipo"] ?? "";

    if (empty($username) || empty($password) || empty($tipo)) {
        die("Por favor, preencha todos os campos.");
    }

    $db = new SQLite3(__DIR__ . '/../dados/imobiliaria.db');

    $db->exec("CREATE TABLE IF NOT EXISTS utilizadores (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT,
        tipo TEXT,
        ultimo_acesso TEXT
    )");

    $stmt = $db->prepare("SELECT * FROM utilizadores WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        echo "Este utilizador já existe!";
    } else {
        $stmt = $db->prepare("INSERT INTO utilizadores (username, password, tipo) VALUES (:username, :password, :tipo)");
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindValue(":tipo", $tipo);
        $stmt->execute();

        echo "Utilizador registado com sucesso!";
        // header("refresh:2;url=login.html"); // opcional
    }
}
?>