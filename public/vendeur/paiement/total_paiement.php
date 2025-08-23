<?php
header('Content-Type: application/json');

// Connexion à la base
require __DIR__ . '/../../../inc/db.php';

$pointVente = isset($_POST['pointVente']) ? $_POST['pointVente'] : null;

try {
    if ($pointVente) {
        $sql = "SELECT SUM(montant) as total FROM paiement WHERE DATE(date_heure_paiement) = CURDATE() AND nom_point_vente = :pointVente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pointVente' => $pointVente]);
    } else {
        // si tu veux le total de TOUT
        $sql = "SELECT SUM(montant) as total FROM paiement";
        $stmt = $pdo->query($sql);
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'] ?? 0;

    echo json_encode([
        "success" => true,
        "total" => (int)$total
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
