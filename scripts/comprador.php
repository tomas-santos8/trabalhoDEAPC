<?php
session_start();
$_SESSION['tipo'] = 'comprador';
$_SESSION['username'] = 'tomas';
$_SESSION['id'] = 1;

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comprador') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Ligação à base de dados de imóveis
$db = new SQLite3('../DADOS/imoveis.db');
$result = $db->query("SELECT * FROM imoveis");

$imoveis_exemplo = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $imoveis_exemplo[] = $row;
}

// Ligação à base de dados de mensagens
$mensagensDB = new SQLite3('../DADOS/mensagens.db');

// Guardar nova mensagem (se enviada)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);
    if (!empty($mensagem)) {
        $stmt = $mensagensDB->prepare("INSERT INTO mensagens (remetente, destinatario, mensagem)
                                       VALUES (:remetente, :destinatario, :mensagem)");
        $stmt->bindValue(':remetente', $username);
        $stmt->bindValue(':destinatario', 'agente');
        $stmt->bindValue(':mensagem', $mensagem);
        $stmt->execute();

        header("Location: comprador.php");
        exit;
    }
}

//  Propostas fictícias mantidas
$propostas_exemplo = [
    ['titulo' => 'Moradia A', 'estado' => 'Em análise'],
    ['titulo' => 'Apartamento B', 'estado' => 'Aceite']
];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Comprador</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
      display: flex;
      gap: 2rem;
    }

    .container {
      flex: 2;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
      padding: 2rem;
    }

    .imovel {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 1rem;
      display: flex;
      flex-direction: column;
    }

    .imovel img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 0.5rem;
    }

    .imovel p {
      margin: 0.4rem 0;
    }

    .detalhes {
      flex: 1;
      background-color: #f4f4f4;
      border-left: 2px solid #ccc;
      padding: 1.5rem;
      display: none;
      flex-direction: column;
      justify-content: space-between;
    }

    .detalhes.active {
      display: flex;
    }

    .detalhes-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .detalhes button.close {
      background: black;
      color: white;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      border-radius: 5px;
      padding: 0 0.6rem;
    }

    .detalhes form {
      margin-top: 1rem;
    }

    .negociacoes, .mensagens {
      background-color: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin: 2rem;
    }

    .status {
      font-weight: bold;
    }

    .status.aceite {
      color: #44bd32;
    }

    .status.analise {
      color: #f39c12;
    }

    nav span {
      font-weight: bold;
      color: #fff;
      margin-right: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Imóveis CDT</h1>
    <nav>
      <span>Bem-vindo, <?php echo htmlspecialchars($username); ?></span>
      <a class="btn" href="logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <!-- Lista de imóveis -->
    <div class="container">
      <?php foreach ($imoveis_exemplo as $imovel): ?>
        <article class="imovel">
          <img src="../<?php echo htmlspecialchars($imovel['imagem'] ?? 'images/casa1.jpg'); ?>" alt="Imagem do imóvel">
          <p><strong><?php echo htmlspecialchars($imovel['titulo']); ?></strong></p>
          <p><?php echo htmlspecialchars($imovel['localizacao']); ?> – <?php echo number_format($imovel['preco'], 2); ?>€</p>

          <button onclick='verDetalhes(<?php echo json_encode($imovel); ?>)'>Pedir Informação</button>
        </article>
      <?php endforeach; ?>
    </div>

    <!-- Painel lateral de detalhes -->
    <aside id="detalhes" class="detalhes">
      <div class="detalhes-header">
        <h2>Detalhes do Imóvel</h2>
        <button class="close" onclick="fecharDetalhes()">×</button>
      </div>
      <div id="detalheConteudo">
        <p>Seleciona um imóvel para ver detalhes.</p>
      </div>
    </aside>
  </main>

  <section class="negociacoes">
    <h2>Minhas Negociações</h2>
    <?php foreach ($propostas_exemplo as $p): ?>
      <p><strong><?php echo htmlspecialchars($p['titulo']); ?></strong> — Estado:
        <span class="status <?php echo $p['estado'] === 'Aceite' ? 'aceite' : 'analise'; ?>">
          <?php echo htmlspecialchars($p['estado']); ?>
        </span>
      </p>
    <?php endforeach; ?>
  </section>

  <section class="mensagens">
    <h2>Mensagens com o Agente</h2>

    <?php
    $stmt = $mensagensDB->prepare("SELECT * FROM mensagens 
                                   WHERE (remetente = :user AND destinatario = 'agente') 
                                      OR (remetente = 'agente' AND destinatario = :user)
                                   ORDER BY data_envio ASC");
    $stmt->bindValue(':user', $username);
    $result = $stmt->execute();

    while ($msg = $result->fetchArray(SQLITE3_ASSOC)): ?>
      <div style="margin: 0.5rem 0;">
        <strong><?= htmlspecialchars($msg['remetente']) ?>:</strong>
        <?= htmlspecialchars($msg['mensagem']) ?>
        <span style="font-size: 0.8rem; color: gray;">(<?= $msg['data_envio'] ?>)</span>
      </div>
    <?php endwhile; ?>

    <form method="POST" style="margin-top: 1rem;">
      <textarea name="mensagem" rows="3" style="width: 100%; padding: 0.5rem;" required placeholder="Escreve uma mensagem..."></textarea>
      <button type="submit" style="margin-top: 0.5rem;">Enviar</button>
    </form>
  </section>

  <script>
    function verDetalhes(imovel) {
      const painel = document.getElementById("detalhes");
      const conteudo = document.getElementById("detalheConteudo");

      const precoFormatado = parseFloat(imovel.preco).toLocaleString('pt-PT');

      conteudo.innerHTML = `
        <img src="../${imovel.imagem || 'images/casa1.jpg'}" alt="Imagem do imóvel" style="max-width: 100%; border-radius: 10px; margin-bottom: 1rem;">
        <p><strong>Título:</strong> ${imovel.titulo}</p>
        <p><strong>Localização:</strong> ${imovel.localizacao}</p>
        <p><strong>Preço:</strong> ${precoFormatado}€</p>
        
        <form method="POST" action="#">
          <label for="valor">Fazer Proposta (€):</label>
          <input type="number" name="valor" step="5000" min="0" value="${imovel.preco}" required>
          <button type="submit">Fazer Proposta</button>
        </form>
      `;

      painel.classList.add("active");
    }

    function fecharDetalhes() {
      document.getElementById("detalhes").classList.remove("active");
    }
  </script>
</body>
</html>