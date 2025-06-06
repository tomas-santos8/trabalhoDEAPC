<?php
session_start();
$_SESSION['tipo'] = 'comprador';
$_SESSION['username'] = 'tomas';
$_SESSION['id'] = 1;

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comprador') {
    header("Location: ../scripts/login.php");
    exit;
}

$username = $_SESSION['username'];

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

    .negociacoes {
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
    <!-- Lista de imóveis -->
    <div class="container">
      <?php foreach ($imoveis_exemplo as $imovel): ?>
        <article class="imovel">
          <img src="../images/casa<?php echo rand(1,3); ?>.jpg" alt="Imagem do imóvel">
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

  <script>
    function verDetalhes(imovel) {
      const painel = document.getElementById("detalhes");
      const conteudo = document.getElementById("detalheConteudo");

      conteudo.innerHTML = `
        <img src="${imovel.imagem || '../images/casa1.jpg'}" alt="Imagem do imóvel" style="max-width: 100%; border-radius: 10px; margin-bottom: 1rem;">
        <p><strong>Título:</strong> ${imovel.titulo}</p>
        <p><strong>Localização:</strong> ${imovel.localizacao}</p>
        <p><strong>Preço:</strong> ${parseFloat(imovel.preco).toLocaleString('pt-PT')}€</p>
        <form method="POST" action="#">
          <label for="valor">Fazer Proposta (€):</label>
          <input type="number" name="valor" required>
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