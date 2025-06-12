<?php

// Conexão com a base de dados de imóveis
$db = new SQLite3('../DADOS/imoveis.db');
$result = $db->query("SELECT * FROM imoveis");

// Carregar os imóveis da base para o array
$imoveis = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $imoveis[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Vendedor</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    .container {
      display: flex;
    }

    .coluna {
      flex: 1;
      padding: 1rem;
    }

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
    }

    .btn-remover {
      background-color: black;
      color: white;
      border: none;
      padding: 0.3rem 0.7rem;
      margin-left: 0.5rem;
      cursor: pointer;
      border-radius: 3px;
      font-size: 0.9rem;
    }

    .imovel {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .imovel img {
      max-width: 100%;
      border-radius: 5px;
      margin-bottom: 0.5rem;
    }

    .imovel p {
      margin: 0.3rem 0;
    }

    .imovel button {
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Área do Vendedor</h1>
    <nav>
      <a href="../HTML/index.html" class="btn">Início</a>
      <a href="adicionar_imoveis.php" class="btn">Adicionar Imóvel</a>
      <a href="logout.php" class="btn">Sair</a>
    </nav>
  </header>

  <main class="container">
    <!-- Coluna dos imóveis -->
    <section class="coluna">
      <h2>Meus Imóveis</h2>

      <?php if (empty($imoveis)): ?>
        <p>Nenhum imóvel disponível.</p>
      <?php else: ?>
        <?php foreach ($imoveis as $imovel): ?>
          <article class="imovel">
            <img src="../<?= htmlspecialchars($imovel['imagem']) ?>" alt="Imagem do imóvel">
            <p><strong>Título:</strong> <?= htmlspecialchars($imovel['titulo']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
            <p><strong>Preço:</strong> <?= number_format($imovel['preco'], 0, ',', '.') ?>€</p>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($imovel['descricao']) ?></p>
            <button onclick='verDetalhes(<?= json_encode($imovel) ?>)'>Ver Detalhes</button>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
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
        <img src="../${imovel.imagem}" alt="Imagem do imóvel" style="max-width: 100%; margin-bottom: 1rem;">
        <p><strong>Título:</strong> ${imovel.titulo}</p>
        <p><strong>Localização:</strong> ${imovel.localizacao}</p>
        <p><strong>Preço:</strong> ${Number(imovel.preco).toLocaleString('pt-PT')}€</p>
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