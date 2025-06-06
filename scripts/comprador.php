<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Comprador</title>
  <link rel="stylesheet" href="../styles/style.css">
  <style>
    .container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
    }

    .imovel {
      display: flex;
      flex-direction: column;
    }

    .imovel form {
      margin-top: 0.5rem;
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
    }

    .imovel p {
      margin: 0.4rem 0;
    }

    .imovel input[type="number"] {
      margin-top: 0.5rem;
      padding: 0.5rem;
      width: 100%;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
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
      <?php foreach ($propostas_exemplo as $p) : ?>
        <p><strong><?php echo htmlspecialchars($p['titulo']); ?></strong> — Estado: 
        <span style="color: <?php echo $p['estado'] === 'Aceite' ? '#44bd32' : '#f39c12'; ?>">
          <?php echo htmlspecialchars($p['estado']); ?>
        </span></p>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>