<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    $_SESSION['flash'] = 'Requête invalide (CSRF).';
    header('Location: index.php'); exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($username === '' || $password === '') {
    $_SESSION['flash'] = 'Remplissez tous les champs.';
    header('Location: index.php'); exit;
}

require __DIR__ . '/../inc/db.php';
$stmt = $pdo->prepare('SELECT id, username, password, role, point_of_sale FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    //$pv = (int)$user['point_of_sale'];
    $pv_choice = $_POST['point_of_sale'];

    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
        'point_of_sale' => $pv_choice
    ];
    
    if ($user['role'] === 'admin') {
        header("Location: admin.php?pv=$pv_choice");
    } else {
        header("Location: vendeur.php?pv=$pv_choice");
    }
    exit;
} else {
    $_SESSION['flash'] = 'Nom d’utilisateur ou mot de passe incorrect.';
    header('Location: index.php'); exit;
}
