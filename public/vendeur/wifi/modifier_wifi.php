<?php
// modifier_wifi.php
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

require __DIR__ . '/../../../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Méthode invalide']);
    exit;
}

$id             = (int)($_POST['id'] ?? 0);
$montant_limite = isset($_POST['montant_limite']) ? (float)$_POST['montant_limite'] : 0;
$commentaire    = trim($_POST['commentaire'] ?? '');

if ($id <= 0) {
    echo json_encode(['success'=>false,'error'=>'ID invalide']);
    exit;
}

$stmt = $pdo->prepare("UPDATE wifi SET montant_limite = :lim, commentaire = :com WHERE id = :id");
$ok = $stmt->execute([
    'lim' => $montant_limite,
    'com' => $commentaire,
    'id'  => $id
]);

echo json_encode(['success'=>$ok]);
