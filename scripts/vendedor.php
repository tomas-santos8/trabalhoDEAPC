<?php
$imoveis = [
    [
        "imagem" => "images/casa2.jpg",
        "localizacao" => "Porto",
        "preco" => 300000,
        "propostas" => 280000,
        "descricao" => "Moradia moderna com 3 quartos, jardim e garagem."
    ],
    [
        "imagem" => "images/casa3.jpg",
        "localizacao" => "Lisboa",
        "preco" => 450000,
        "propostas" => 440000,
        "descricao" => "Apartamento T2 no centro com varanda e vista rio."
    ]
];

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
      display: none; /* escondido até clicar */
    }
  </style>
</head>
<body>
  <header>
    <h1>Área do Vendedor</h1>
    <nav>
      <a href="index.html" class="btn">Início</a>
      <a href="adicionar-imovel.html" class="btn">Adicionar Imóvel</a>
      <a href="logout.html" class="btn">Sair</a>
    </nav>
  </header>

  <main class="container">
    <!-- Coluna dos imóveis -->
    <section class="coluna">
      <h2>Meus Imóveis</h2>
      <?php foreach ($imoveis as $index => $imovel): ?>
        <article class="imovel">
          <img src="<?= $imovel['imagem'] ?>" alt="Imagem do imóvel">
          <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
          <p><strong>Preço:</strong> <?= number_format($imovel['preco'], 0, ',', '.') ?>€</p>
          <p><strong>Propostas Recebidas:</strong> <?= number_format($imovel['propostas'], 0, ',', '.') ?>€</p>
          <button onclick="verDetalhes(<?= htmlspecialchars(json_encode($imovel)) ?>)">Ver Detalhes</button>
        </article>
      <?php endforeach; ?>
    </section>

    <!-- Coluna dos detalhes -->
    <section id="detalhes" class="coluna">
      <h2>Detalhes do Imóvel</h2>
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
        <p><strong>Preço:</strong> ${imovel.preco.toLocaleString('pt-PT')}€</p>
        <p><strong>Propostas Recebidas:</strong> ${imovel.propostas.toLocaleString('pt-PT')}€</p>
        <p><strong>Descrição:</strong> ${imovel.descricao}</p>
      `;
      detalhes.style.display = 'block'; // mostra a coluna dos detalhes
    }
  </script>
</body>
</html>
