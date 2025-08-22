<?php

session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Accès non autorisé']);
    exit;
}

$DB_HOST = '127.0.0.1';
$DB_NAME = 'db_cyber';
$DB_USER = 'root';
$DB_PASS = 'julio';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erreur connexion DB']);
    exit;
}

// Récupération des données POST
$montant = isset($_POST['montant']) ? intval($_POST['montant']) : 0;
$type_service = isset($_POST['type_service']) ? trim($_POST['type_service']) : '';
$commentaire = isset($_POST['commentaire']) && $_POST['commentaire'] !== '' ? trim($_POST['commentaire']) : 'normal';
$nom_vendeur = $_SESSION['user']['username'] ?? 'Inconnu';
$nom_point_vente = $_SESSION['user']['point_of_sale'] ?? '';

if ($montant <= 0 || empty($type_service)) {
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir montant et type_service']);
    exit;
}

// Insertion
$stmt = $pdo->prepare("INSERT INTO paiement (montant, type_service, commentaire, nom_vendeur, nom_point_vente) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$montant, $type_service, $commentaire, $nom_vendeur, $nom_point_vente]);

// Récupérer le dernier enregistrement inséré pour l’afficher
$id = $pdo->lastInsertId();
$newRow = $pdo->query("SELECT * FROM paiement WHERE id = $id")->fetch();

echo json_encode(['status' => 'success', 'data' => $newRow]);
