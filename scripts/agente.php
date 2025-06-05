<!-- agente.php -->
<?php
  // Simulação de dados (substituir por dados reais do BD no futuro)
  $propriedadesParaValidar = [
    ["nome" => "Moradia Y", "local" => "Lisboa"]
  ];

  $negociacoes = [
    ["propriedade" => "Moradia Z", "partes" => "Dono vs Comprador"]
  ];

  $mensagens = [
    ["autor" => "Comprador", "mensagem" => "Gostaria de visitar."]
  ];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Agente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <main class="container">
    <h1>Área do Agente Imobiliário</h1>

    <!-- Propriedades para Validar -->
    <section class="card">
      <h2>Propriedades para Validar</h2>
      <?php if (empty($propriedadesParaValidar)): ?>
        <p>Sem propriedades pendentes.</p>
      <?php else: ?>
        <?php foreach ($propriedadesParaValidar as $prop): ?>
          <div class="item">
            <span><?= htmlspecialchars($prop["nome"]) ?> - <?= htmlspecialchars($prop["local"]) ?></span>
            <form method="post" action="validar_propriedade.php">
              <input type="hidden" name="propriedade" value="<?= htmlspecialchars($prop["nome"]) ?>">
              <button type="submit" class="btn-validar">Validar</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <!-- Negociações -->
    <section class="card">
      <h2>Negociações Ativas</h2>
      <?php if (empty($negociacoes)): ?>
        <p>Sem negociações no momento.</p>
      <?php else: ?>
        <?php foreach ($negociacoes as $neg): ?>
          <div class="item">
            <span><?= htmlspecialchars($neg["propriedade"]) ?></span>
            <small><?= htmlspecialchars($neg["partes"]) ?></small>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <!-- Mensagens -->
    <section class="card">
      <h2>Mensagens Recentes</h2>
      <?php if (empty($mensagens)): ?>
        <p>Sem mensagens.</p>
      <?php else: ?>
        <?php foreach ($mensagens as $msg): ?>
          <div class="item">
            <strong><?= htmlspecialchars($msg["autor"]) ?>:</strong>
            <span>"<?= htmlspecialchars($msg["mensagem"]) ?>"</span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
