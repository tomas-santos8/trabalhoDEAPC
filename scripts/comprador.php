<?php
session_start();

// Simular login de teste (apaga esta parte quando usares sessão real)
$_SESSION['tipo'] = 'comprador';
$_SESSION['username'] = 'joao123';
$_SESSION['id'] = 1;

// Verificar tipo de utilizador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comprador') {
    header("Location: ../scripts/login.php");
    exit;
}

$username = $_SESSION['username'];

// Exemplos fictícios
$imoveis_exemplo = [
    [
        'id' => 1,
        'titulo' => 'Moradia A',
        'localizacao' => 'Lisboa',
        'preco' => 250000
    ],
    [
        'id' => 2,
        'titulo' => 'Apartamento B',
        'localizacao' => 'Porto',
        'preco' => 180000
    ]
];

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
  <link rel="stylesheet" href="../styles/style.css">
  <style>
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
    }
    .imovel form {
      margin-top: 1rem;
    }
    section.negociacoes {
      margin-top: 3rem;
      background-color: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      max-width: 600px;
    }
    section.negociacoes p {
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Imóveis CDT</h1>
    <nav>
      <span>Bem-vindo, <?php echo htmlspecialchars($username); ?></span>
      <a class="btn" href="#">Logout</a>
    </nav>
  </header>

  <main>
    <h2>Propriedades Disponíveis</h2>
    <div class="container">
      <?php foreach ($imoveis_exemplo as $imovel) : ?>
        <article class="imovel">
          <img src="../images/casa<?php echo rand(1,3); ?>.jpg" alt="Imagem do imóvel">
          <p><strong><?php echo htmlspecialchars($imovel['titulo']); ?></strong></p>
          <p><?php echo htmlspecialchars($imovel['localizacao']); ?> - <?php echo number_format($imovel['preco'], 2); ?>€</p>

          <form action="#" method="POST">
            <button type="submit">Pedir Informação</button>
          </form>

          <form action="#" method="POST">
            <input type="number" name="valor" placeholder="Valor da Proposta (€)" required>
            <button type="submit">Fazer Proposta</button>
          </form>
        </article>
      <?php endforeach; ?>
    </div>

    <h2>Minhas Negociações</h2>
    <section class="negociacoes">
      <?php foreach ($propostas_exemplo as $p) : ?>
        <p><strong><?php echo htmlspecialchars($p['titulo']); ?></strong> — Estado: <?php echo htmlspecialchars($p['estado']); ?></p>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>