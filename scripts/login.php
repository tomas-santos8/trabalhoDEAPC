<?php
$db = new SQLite3('../DADOS/imobiliaria.db');
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

    // Redirecionamento com base no tipo
    switch ($result['tipo']) {
        case 'comprador':
            header("Location: comprador.php");
            exit;
        case 'vendedor':
        case 'dono': // Se usares 'dono' em vez de 'vendedor'
            header("Location: vendedor.php");
            exit;
        case 'agente':
            header("Location: agente.php");
            exit;
        default:
            echo "Tipo de utilizador desconhecido.";
            exit;
    }

} else {
    echo "Credenciais inválidas!";
}
?>