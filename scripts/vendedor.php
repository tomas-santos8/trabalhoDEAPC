<?php
// Simulação de dados (em produção, estes viriam de uma base de dados)
$imoveis = [
    [
        "imagem" => "images/casa2.jpg",
        "localizacao" => "Porto",
        "preco" => 300000,
        "propostas" => 280000
    ],
    // Podes adicionar mais imóveis aqui
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

  <main>
    <section>
      <h2>Meus Imóveis</h2>

      <?php foreach ($imoveis as $imovel): ?>
        <article class="imovel">
          <img src="<?= $imovel['imagem'] ?>" alt="Imagem do imóvel">
          <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
          <p><strong>Preço:</strong> <?= number_format($imovel['preco'], 0, ',', '.') ?>€</p>
          <p><strong>Propostas Recebidas:</strong> <?= number_format($imovel['propostas'], 0, ',', '.') ?>€</p>
          <button>Ver Detalhes</button>
        </article>
      <?php endforeach; ?>
    </section>

    <section>
      <h2>Mensagens</h2>
      <div class="imovel">
        <?php foreach ($mensagens as $msg): ?>
          <p><strong><?= htmlspecialchars($msg) ?></strong></p>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
</body>
</html>
