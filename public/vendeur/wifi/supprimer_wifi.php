<?php
// supprimer_wifi.php
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

require __DIR__ . '/../../../inc/db.php';

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM wifi WHERE id = :id");
$ok = $stmt->execute(['id' => $id]);

echo json_encode(['success' => $ok]);
