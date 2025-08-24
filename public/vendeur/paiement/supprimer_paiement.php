<?php

session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Accès non autorisé']);
    exit;
}


header("Content-Type: application/json");

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=db_cyber;charset=utf8", "root", "julio", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $id = $_POST['id'] ?? null;
    $cause = trim($_POST['cause'] ?? '');

    if (!$id || $cause === '') {
        echo json_encode(["success" => false, "message" => "ID ou cause manquant"]);
        exit;
    }

    // Récupérer les infos avant suppression
    $stmt = $pdo->prepare("SELECT * FROM paiement WHERE id = ?");
    $stmt->execute([$id]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$paiement) {
        echo json_encode(["success" => false, "message" => "Paiement introuvable"]);
        exit;
    }
    

    // Insérer dans paiement_suppression
    $insert = $pdo->prepare("
        INSERT INTO paiement_suppression 
        (paiement_id, montant, type_service, commentaire, nom_vendeur, nom_point_vente, date_heure_paiement, cause, versement_pure, date_suppression)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $insert->execute([
        $paiement['id'],
        $paiement['montant'],
        $paiement['type_service'],
        $paiement['commentaire'],
        $paiement['nom_vendeur'],
        $paiement['nom_point_vente'],
        $paiement['date_heure_paiement'],
        $cause,
        $paiement['versement_pure']
    ]);

    // Supprimer le paiement original
    $delete = $pdo->prepare("DELETE FROM paiement WHERE id = ?");
    $delete->execute([$id]);

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
