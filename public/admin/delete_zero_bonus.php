<?php
session_start();
require __DIR__ . '/../../inc/db.php';



try {
    $stmt = $pdo->prepare("DELETE FROM bonus WHERE montant_bonus = 0");
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
