<?php
require_once 'db.php'; // Ligação à base de dados

// Buscar imóveis da base de dados
$stmt = $pdo->query("SELECT * FROM imoveis");
$imoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mensagens estáticas (ou podes ler de uma tabela)
$mensagens = [
    "Agente: Temos uma nova proposta.",
    "Cliente: Gostaria de visitar a casa este sábado."
];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Vendedor</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    .container { display: flex; }
    .coluna { flex: 1; padding: 1rem; }
    #detalhes {
      background-color: #f4f4f4;
      border-left: 2px solid #ccc;
      display: none;
    }
    #fecharDetalhes {
      background: black;
      color: white;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      font-weight: bold;
      line-height: 1;
      padding: 0 0.5rem;
      border-radius: 3px;
      transition: background-color 0.3s ease;
    }
    #fecharDetalhes:hover { background: #333; }
  </style>
</head>
<body>
  <header>
    <h1>Área do Vendedor</h1>
    <nav>
      <a href="index.html" class="btn">Início</a>
      <a href="adicionar_imoveis.php" class="btn">Adicionar Imóvel</a>
      <a href="logout.php" class="btn">Sair</a>
    </nav>
  </header>

  <main class="container">
    <!-- Coluna dos imóveis -->
    <section class="coluna">
      <h2>Meus Imóveis</h2>
      <?php foreach ($imoveis as $imovel): ?>
        <article class="imovel">
          <img src="<?= htmlspecialchars($imovel['imagem']) ?>" alt="Imagem do imóvel">
          <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
          <p><strong>Preço:</strong> <?= number_format($imovel['preco'], 0, ',', '.') ?>€</p>
          <p><strong>Propostas Recebidas:</strong> <?= number_format($imovel['propostas'], 0, ',', '.') ?>€</p>
          <button onclick='verDetalhes(<?= json_encode($imovel, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Ver Detalhes</button>
        </article>
      <?php endforeach; ?>
    </section>

    <!-- Coluna dos detalhes -->
    <section id="detalhes" class="coluna">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Detalhes do Imóvel</h2>
        <button id="fecharDetalhes" aria-label="Fechar detalhes">×</button>
      </div>
      <div id="detalhe-conteudo">
        <p>Seleciona um imóvel para ver os detalhes.</p>
      </div>
    </section>
  </main>

  <script>
    function verDetalhes(imovel) {
      const detalhes = document.getElementById('detalhes');
      const conteudo = document.getElementById('detalhe-conteudo');

      conteudo.innerHTML = `
        <img src="${imovel.imagem}" alt="Imagem" style="max-width: 100%; height: auto;">
        <p><strong>Localização:</strong> ${imovel.localizacao}</p>
        <p><strong>Preço:</strong> ${parseFloat(imovel.preco).toLocaleString('pt-PT')}€</p>
        <p><strong>Propostas Recebidas:</strong> ${parseFloat(imovel.propostas).toLocaleString('pt-PT')}€</p>
        <p><strong>Descrição:</strong> ${imovel.descricao}</p>
      `;
      detalhes.style.display = 'block';
    }

    document.getElementById('fecharDetalhes').addEventListener('click', () => {
      document.getElementById('detalhes').style.display = 'none';
    });
  </script>
</body>
</html>