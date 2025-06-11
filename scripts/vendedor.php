<?php
$imoveis = [
    [
        "imagem" => "../images2/casa1.jpg",
        "localizacao" => "Gaia",
        "preco" => 500000,
        "propostas" => 480000,
        "descricao" => "Moradia moderna com 3 quartos,4 casas de banho,piscina, jardim, garagem, cozinha moderna e uma sala de estar com bastante luminosidade."
    ],
    [
        "imagem" => "../images3/casa1.jpg",
        "localizacao" => "Lisboa",
        "preco" => 450000,
        "propostas" => 440000,
        "descricao" => "casa de luxo perto do centro de lisboa."
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
    #fecharDetalhes:hover {
      background: #333;
    }
    /* Estilo para o botão remover */
    .btn-remover {
      background-color: black;
      color: white;
      border: none;
      padding: 0.3rem 0.7rem;
      margin-left: 0.5rem;
      cursor: pointer;
      border-radius: 3px;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
    }
    .btn-remover:hover {
      background-color: #333;
    }
    /* Um pouco de margem entre os botões */
    article.imovel button {
      margin-top: 0.5rem;
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
          <button onclick='verDetalhes(<?= htmlspecialchars(json_encode($imovel)) ?>)'>Ver Detalhes</button>
          <button class="btn-remover" onclick='removerImovel(this)'>Remover</button>
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
        <p><strong>Preço:</strong> ${imovel.preco.toLocaleString('pt-PT')}€</p>
        <p><strong>Propostas Recebidas:</strong> ${imovel.propostas.toLocaleString('pt-PT')}€</p>
        <p><strong>Descrição:</strong> ${imovel.descricao}</p>
      `;
      detalhes.style.display = 'block';
    }

    function removerImovel(botao) {
      const artigo = botao.closest('article');
      if (confirm("Tem certeza de que deseja remover este imóvel?")) {
        artigo.remove();

        // Se o painel de detalhes estiver visível com esse imóvel, escondê-lo
        const detalhes = document.getElementById('detalhes');
        const imgSrc = artigo.querySelector('img').src;
        const detalheImg = document.querySelector('#detalhe-conteudo img');
        if (detalheImg && detalheImg.src === imgSrc) {
          detalhes.style.display = 'none';
          document.getElementById('detalhe-conteudo').innerHTML = '<p>Seleciona um imóvel para ver os detalhes.</p>';
        }
      }
    }

    document.getElementById('fecharDetalhes').addEventListener('click', () => {
      document.getElementById('detalhes').style.display = 'none';
    });
  </script>
</body>
</html>
