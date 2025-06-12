<?php
session_start();
$agente_nome = 'agente'; // Em produção: usar $_SESSION['username']

// Conectar à base de dados de mensagens
$mensagensDB = new SQLite3('../DADOS/mensagens.db');

// Guardar nova mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
    $remetente = $_POST['remetente'] ?? 'agente';
    $destinatario = $_POST['destinatario'] ?? 'comprador';
    $mensagem = trim($_POST['mensagem']);

    if (!empty($mensagem)) {
        $stmt = $mensagensDB->prepare("INSERT INTO mensagens (remetente, destinatario, mensagem) 
                                       VALUES (:remetente, :destinatario, :mensagem)");
        $stmt->bindValue(':remetente', $remetente);
        $stmt->bindValue(':destinatario', $destinatario);
        $stmt->bindValue(':mensagem', $mensagem);
        $stmt->execute();

        header("Location: agente.php");
        exit;
    }
}

// Obter mensagens trocadas com o agente
$mensagens = [];
$stmt = $mensagensDB->prepare("SELECT * FROM mensagens 
                               WHERE remetente = 'agente' OR destinatario = 'agente'
                               ORDER BY data_envio ASC");
$result = $stmt->execute();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $mensagens[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Agente</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    .container {
      display: flex;
      flex-direction: column;
      gap: 2rem;
      padding: 2rem;
    }
    .card {
      background-color: #f4f4f4;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .mensagem {
      border-bottom: 1px solid #ccc;
      padding: 0.5rem 0;
    }
    .mensagem strong {
      display: block;
    }
    form textarea, form input[type="text"] {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.4rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    form button {
      margin-top: 0.7rem;
      background-color: #273c75;
      color: white;
      border: none;
      padding: 0.6rem 1rem;
      border-radius: 5px;
      cursor: pointer;
    }
    form button:hover {
      background-color: #192a56;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin-left: 1rem;
      background-color: #00a8ff;
      padding: 0.4rem 0.8rem;
      border-radius: 5px;
    }
    nav a:hover {
      background-color: #0097e6;
    }
  </style>
</head>
<body>
  <header style="background-color: #273c75; color: white; padding: 1rem 2rem;">
    <h1>Área do Agente Imobiliário</h1>
    <nav>
      <a href="../HTML/index.html">Início</a>
      <a href="logout.php">Sair</a>
    </nav>
  </header>

  <main class="container">

    <!-- Validação de propriedades fictícias -->
    <section class="card">
      <h2>Propriedades para Validar</h2>
      <p>(Funcionalidade demonstrativa — integrar com base real se necessário)</p>
      <ul>
        <li>Moradia T3 - Aveiro <button onclick="alert('✅ Validado!')">Validar</button></li>
        <li>Apartamento T2 - Porto <button onclick="alert('✅ Validado!')">Validar</button></li>
      </ul>
    </section>

    <!-- Mensagens -->
    <section class="card">
      <h2>Mensagens com Clientes</h2>

      <?php if (empty($mensagens)): ?>
        <p>Não há mensagens ainda.</p>
      <?php else: ?>
        <?php foreach ($mensagens as $msg): ?>
          <div class="mensagem">
            <strong><?= htmlspecialchars($msg['remetente']) ?> → <?= htmlspecialchars($msg['destinatario']) ?>:</strong>
            <?= htmlspecialchars($msg['mensagem']) ?>
            <div style="font-size: 0.8rem; color: gray;"><?= $msg['data_envio'] ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <form method="POST" style="margin-top: 1rem;">
        <h3>Responder</h3>
        <label for="destinatario">Destinatário:</label>
        <input type="text" name="destinatario" required placeholder="Ex: tomas">

        <label for="mensagem">Mensagem:</label>
        <textarea name="mensagem" rows="3" required placeholder="Escreve a mensagem..."></textarea>

        <button type="submit">Enviar</button>
      </form>

      <form method="GET" style="margin-top: 0.5rem;">
        <button type="submit">🔄 Atualizar mensagens</button>
      </form>
    </section>
  </main>
</body>
</html>