<?php
session_start();

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new SQLite3('../DADOS/imobiliaria.db');

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {
        $stmt = $db->prepare('SELECT * FROM utilizadores WHERE email = ?');
        $stmt->bindValue(1, $email);
        $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        // Comparação direta (sem hash)
        if ($user && $password === $user['password']) {
            $_SESSION['user'] = $user;
            $_SESSION['username'] = $user['username'];
            $_SESSION['tipo'] = $user['tipo'];
            $_SESSION['id'] = $user['id'];

            $update = $db->prepare('UPDATE utilizadores SET ultimo_acesso = datetime("now") WHERE id = ?');
            $update->bindValue(1, $user['id']);
            $update->execute();

            switch ($user['tipo']) {
                case 'comprador':
                    header("Location: ../HTML/comprador.html");
                    break;
                case 'vendedor':
                    header("Location: ../scripts/vendedor.php");
                    break;
                case 'agente':
                    header("Location: ../HTML/agente.html");
                    break;
            }
            exit;
        } else {
            $mensagem = "Utilizador ou palavra-passe incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../styles/modelo.css">
</head>
<body>
  <main class="login">
    <h1>Login</h1>

    <?php if (!empty($mensagem)) : ?>
      <p style="color:red;"><?php echo htmlspecialchars($mensagem); ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
      <label>Email:</label>
      <input type="text" name="email" required>

      <label>Palavra-passe:</label>
      <input type="password" name="password" required>

      <button type="submit">Entrar</button>
    </form>

    <a href="novoregisto.html">Criar conta</a>
  </main>
</body>
</html>
