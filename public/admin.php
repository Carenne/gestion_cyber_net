<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['flash'] = 'Accès non autorisé.';
    header('Location: index.php'); exit;
}
$pv = $_GET['pv'] ?? $_SESSION['user']['point_of_sale'];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Administration — Point de vente <?= $pv ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3>Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) ?> (Admin)</h3>
  <p>Point de vente actif : <strong><?= $pv ?></strong></p>
  <a href="logout.php" class="btn btn-outline-secondary">Se déconnecter</a>
</div>
<p class="mt-2 text-success fw-bold">
  Bienvenue sur <?= $pv ?>
</p>
</body>
</html>
