<?php
require __DIR__ . '/../../../inc/db.php'; // connexion PDO

$pointVente = 'Tok';

$stmt = $pdo->prepare("
    SELECT * 
    FROM paiement 
    WHERE DATE(date_heure_paiement) = CURDATE() 
    AND nom_point_vente = :pointVente
    AND (statut IS NULL OR statut != 'valider')  -- on ignore déjà les paiements validés
    ORDER BY date_heure_paiement DESC
");
$stmt->execute(['pointVente' => $pointVente]);
$paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($paiements);
