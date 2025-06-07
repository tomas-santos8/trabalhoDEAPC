<?php
// Conexão com a base de dados
$db = new SQLite3('../DADOS/imoveis.db');

// Se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $descricao = $_POST['descricao'] ?? '';
    $imagem = $_POST['imagem'] ?? '';

    $stmt = $db->prepare("INSERT INTO imoveis (titulo, localizacao, preco, descricao, imagem)
                          VALUES (:titulo, :localizacao, :preco, :descricao, :imagem)");
    $stmt->bindValue(':titulo', $titulo, SQLITE3_TEXT);
    $stmt->bindValue(':localizacao', $localizacao, SQLITE3_TEXT);
    $stmt->bindValue(':preco', $preco, SQLITE3_INTEGER);
    $stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
    $stmt->bindValue(':imagem', $imagem, SQLITE3_TEXT);

    if ($stmt->execute()) {
        $mensagem = "✅ Imóvel inserido com sucesso!";
    } else {
        $mensagem = "❌ Erro ao inserir: " . $db->lastErrorMsg();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Imóvel</title>
  <link rel="stylesheet" href="../styles/modelo.css">
  <style>
    form {
      background-color: white;
      padding: 2rem;
      max-width: 500px;
      margin: 2rem auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    form label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
    }

    form input, form textarea {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.3rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    form button {
      margin-top: 2rem;
      padding: 0.7rem;
      width: 100%;
      background-color: #44bd32;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
    }

    form button:hover {
      background-color: #4cd137;
    }

    .mensagem {
      text-align: center;
      font-weight: bold;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Imóveis CDT - Adicionar Imóvel</h1>
    <nav>
      <a class="btn" href="comprador.php">Voltar</a>
    </nav>
  </header>

  <main>
    <form method="POST">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" required>

      <label for="localizacao">Localização:</label>
      <input type="text" name="localizacao" required>

      <label for="preco">Preço (€):</label>
      <input type="number" name="preco" required step="1000" min="0">

      <label for="descricao">Descrição:</label>
      <textarea name="descricao" rows="4" required></textarea>

      <label for="imagem">Caminho da Imagem (ex: images/casa1.jpg):</label>
      <input type="text" name="imagem">

      <button type="submit">Guardar Imóvel</button>

      <?php if (isset($mensagem)) echo "<p class='mensagem'>{$mensagem}</p>"; ?>
    </form>
  </main>
</body>
</html>