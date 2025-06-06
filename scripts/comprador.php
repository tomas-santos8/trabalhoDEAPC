<?php
session_start();

// Simulação de sessão
$_SESSION['tipo'] = 'comprador';
$_SESSION['username'] = 'tomas';
$_SESSION['id'] = 1;

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comprador') {
    header("Location: ../scripts/login.php");
    exit;
}

$username = $_SESSION['username'];

// Dados simulados
$imoveis_exemplo = [
    ['id' => 1, 'titulo' => 'Moradia A', 'localizacao' => 'Lisboa', 'preco' => 250000],
    ['id' => 2, 'titulo' => 'Apartamento B', 'localizacao' => 'Porto', 'preco' => 180000]
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
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    .container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
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

    .imovel form {
      margin-top: 0.5rem;
    }

    .imovel input[type="number"] {
      margin-top: 0.5rem;
      padding: 0.5rem;
      width: 100%;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .negociacoes {
      margin-top: 3rem;
      background-color: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .negociacoes p {
      margin: 0.75rem 0;
      font-size: 1rem;
    }

    nav span {
      font-weight: bold;
      color: #fff;
      margin-right: 1rem;
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
      <?php foreach ($imoveis_exemplo as $imovel): ?>
        <article class="imovel">
          <img src="../images/casa<?php echo rand(1,3); ?>.jpg" alt="Imagem do imóvel">
          <p><strong><?php echo htmlspecialchars($imovel['titulo']); ?></strong></p>
          <p><?php echo htmlspecialchars($imovel['localizacao']); ?> – <?php echo number_format($imovel['preco'], 2); ?>€</p>

          <form action="#" method="POST">
            <button type="submit">📄 Pedir Informação</button>
          </form>

          <form action="#" method="POST">
            <input type="number" name="valor" placeholder="Valor da Proposta (€)" required>
            <button type="submit">💶 Fazer Proposta</button>
          </form>
        </article>
      <?php endforeach; ?>
    </div>

    <h2>Minhas Negociações</h2>
    <section class="negociacoes">
      <?php foreach ($propostas_exemplo as $p): ?>
        <p><strong><?php echo htmlspecialchars($p['titulo']); ?></strong> — Estado:
          <span class="status <?php echo $p['estado'] === 'Aceite' ? 'aceite' : 'analise'; ?>">
            <?php echo htmlspecialchars($p['estado']); ?>
          </span>
        </p>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>