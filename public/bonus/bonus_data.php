<?php
require __DIR__ . '/../../inc/db.php';

function getBonusData($pdo, $pointVente) {
    $stmt = $pdo->prepare("
        SELECT * 
        FROM bonus 
        WHERE nom_point_vente = :pointVente
        AND MONTH(date_enregistrement) = MONTH(CURDATE())
        AND YEAR(date_enregistrement) = YEAR(CURDATE())
        AND statut = 'non decaissé'
        ORDER BY date_enregistrement DESC
    ");

    $stmt->execute(['pointVente' => $pointVente]);
    $paiements = $stmt->fetchAll();

    // Calculer la somme des bonus
    $totalBonus = array_sum(array_column($paiements, 'montant_bonus'));

    return [
        'paiements'   => $paiements,
        'totalBonus'  => $totalBonus
    ];
}

/* ---- Mode API JSON (si appelé directement en AJAX) ---- */
if (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    header('Content-Type: application/json; charset=utf-8');

    $pointVente = $_POST['pointVente'] ?? $_GET['pointVente'] ?? null;

    if (!$pointVente) {
        echo json_encode(['error' => 'Point de vente manquant']);
        exit;
    }

    $data = getBonusData($pdo, $pointVente);
    echo json_encode($data);
    exit;
}
