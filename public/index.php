<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

if (!empty($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    $pv = (int)$_SESSION['user']['point_of_sale'];
    if ($role === 'admin') header('Location: admin.php?pv=' . $pv);
    else header('Location: vendeur.php?pv=' . $pv);
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Connexion personnel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 mt-5">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title mb-3">Connexion du personnel</h4>
          <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
          <?php endif; ?>
          <form action="auth.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <div class="mb-3">
              <label for="username" class="form-label">Adresse email</label>
              <input type="email" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
            <label for="point_of_sale" class="form-label">Point de vente</label>
              <select class="form-select" id="point_of_sale" name="point_of_sale" required>
                <option value="Mini-croc">Mini-croc</option>
                <option value="Tok">Tok</option>
                <option value="Surveillance">Surveillance</option>
              </select>
            </div>
            <button class="btn btn-primary w-100" type="submit">Se connecter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
