<?php
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

require __DIR__ . '/../../../inc/db.php';

$id = $_POST['id'] ?? null;
$montant = $_POST['montant'] ?? null;
$type_service = $_POST['type_service'] ?? null;
$commentaire = $_POST['commentaire'] ?? '';
$justification = trim($_POST['justification'] ?? '');

if (!$id || !$montant || !$type_service || $justification === '') {
    echo json_encode(['success' => false, 'message' => 'Champs manquants']);
    exit;
}

// Récupérer l’ancien paiement
$stmt = $pdo->prepare("SELECT * FROM paiement WHERE id = ?");
$stmt->execute([$id]);
$ancien = $stmt->fetch();

if (!$ancien) {
    echo json_encode(['success' => false, 'message' => 'Paiement introuvable']);
    exit;
}

// Enregistrer la trace dans paiement_modification
$insert = $pdo->prepare("
    INSERT INTO paiement_modification
    (paiement_id, ancien_montant, ancien_type_service, ancien_commentaire, 
     nouveau_montant, nouveau_type_service, nouveau_commentaire,
     nom_vendeur, nom_point_vente, justification)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->execute([
    $ancien['id'],
    $ancien['montant'],
    $ancien['type_service'],
    $ancien['commentaire'],
    $montant,
    $type_service,
    $commentaire,
    $_SESSION['user']['username'],
    $_SESSION['user']['point_of_sale'],
    $justification
]);

// Mettre à jour le paiement
$update = $pdo->prepare("UPDATE paiement SET montant=?, type_service=?, commentaire=? WHERE id=?");
$update->execute([$montant, $type_service, $commentaire, $id]);

echo json_encode(['success' => true]);
