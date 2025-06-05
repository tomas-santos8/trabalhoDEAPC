<?php
session_start();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comprador') {
    header("Location: ../scripts/login.php");
    exit;
}

$comprador_id = $_SESSION['id'];
$username = $_SESSION['username'];

$db = new SQLite3('../DADOS/imobiliaria.db');

$imoveis = $db->query("SELECT * FROM imoveis WHERE estado = 'aprovado'");

$propostas = $db->prepare("
    SELECT i.titulo, p.estado
    FROM propostas p
    JOIN imoveis i ON p.imovel_id = i.id
    WHERE p.comprador_id = ?
");
$propostas->bindValue(1, $comprador_id);
$res_propostas = $propostas->execute();
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
      <a class="btn" href="../scripts/logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <h2>Propriedades Disponíveis</h2>
    <div class="container">
      <?php while ($imovel = $imoveis->fetchArray(SQLITE3_ASSOC)) : ?>
        <article class="imovel">
          <img src="../images/casa<?php echo rand(1,3); ?>.jpg" alt="Imagem do imóvel">
          <p><strong><?php echo htmlspecialchars($imovel['titulo']); ?></strong></p>
          <p><?php echo htmlspecialchars($imovel['localizacao']); ?> - <?php echo number_format($imovel['preco'], 2); ?>€</p>

          <form action="pedir_info.php" method="POST">
            <input type="hidden" name="imovel_id" value="<?php echo $imovel['id']; ?>">
            <button type="submit">Pedir Informação</button>
          </form>

          <form action="fazer_proposta.php" method="POST">
            <input type="hidden" name="imovel_id" value="<?php echo $imovel['id']; ?>">
            <input type="number" name="valor" placeholder="Valor da Proposta (€)" required>
            <button type="submit">Fazer Proposta</button>
          </form>
        </article>
      <?php endwhile; ?>
    </div>

    <h2>Minhas Negociações</h2>
    <section class="negociacoes">
      <?php
      $tem_negociacoes = false;
      while ($p = $res_propostas->fetchArray(SQLITE3_ASSOC)) :
        $tem_negociacoes = true;
      ?>
        <p><strong><?php echo htmlspecialchars($p['titulo']); ?></strong> — Estado: <?php echo htmlspecialchars($p['estado']); ?></p>
      <?php endwhile; ?>

      <?php if (!$tem_negociacoes) : ?>
        <p>Sem negociações ativas.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>