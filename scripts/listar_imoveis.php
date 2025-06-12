<?php
$db = new SQLite3('../DADOS/imoveis.db');

// Apagar imóvel se foi pedido por GET
if (isset($_GET['remover'])) {
    $id = (int) $_GET['remover'];
    $db->exec("DELETE FROM imoveis WHERE id = $id");
    header("Location: listar_imoveis.php"); // Refresh para limpar a URL
    exit;
}

// Buscar todos os imóveis
$result = $db->query("SELECT * FROM imoveis");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Lista de Imóveis</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    .container {
      max-width: 800px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
    }

    .imovel {
      border-bottom: 1px solid #ccc;
      padding: 1rem 0;
    }

    .imovel:last-child {
      border-bottom: none;
    }

    .btn-remover {
      background-color: #e84118;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 0.5rem;
    }

    .btn-remover:hover {
      background-color: #c23616;
    }

    .btn-voltar {
      display: inline-block;
      margin-top: 2rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Imóveis Registados</h1>
    
    <?php while ($imovel = $result->fetchArray(SQLITE3_ASSOC)): ?>
      <div class="imovel">
        <p><strong>Título:</strong> <?= htmlspecialchars($imovel['titulo']) ?></p>
        <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
        <p><strong>Preço:</strong> <?= number_format($imovel['preco'], 2) ?> €</p>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($imovel['descricao']) ?></p>
        <form method="GET" onsubmit="return confirm('Tens a certeza que queres remover este imóvel?');">
          <input type="hidden" name="remover" value="<?= $imovel['id'] ?>">
          <button class="btn-remover" type="submit">Remover</button>
        </form>
      </div>
    <?php endwhile; ?>

    <div class="btn-voltar">
      <a class="btn" href="agente.php">← Voltar</a>
    </div>
  </div>
</body>
</html>