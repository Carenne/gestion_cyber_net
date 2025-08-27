<?php
require __DIR__ . '/../../../inc/db.php'; // connexion PDO

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $pdo->prepare("UPDATE paiement SET statut = 'valider' WHERE id = :id");
    $stmt->execute(['id' => $id]);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
