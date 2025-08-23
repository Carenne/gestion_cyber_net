<?php
// ajouter_wifi.php
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

require __DIR__ . '/../../../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Méthode invalide']);
    exit;
}

$montant_limite = isset($_POST['montant_limite']) ? (float)$_POST['montant_limite'] : 0;
$commentaire    = trim($_POST['commentaire'] ?? '');
$lieu_travail   = $_SESSION['user']['point_of_sale'] ?? '';
//$lieu_travail   = 'f';
$nom_gerant     = htmlspecialchars($_SESSION['user']['username'] ?? 'inconnu');


if ($lieu_travail === '') {
    echo json_encode(['success'=>false,'error'=>'pointVente manquant']);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO wifi (heure_demarrage, heure_fin, temps, prix, montant_limite, commentaire, lieu_travail, nom_vendeur)
    VALUES (CURRENT_TIME, CURRENT_TIME, 0, 0, :lim, :com, :lieu, :gerant)
");
$stmt->execute([
    'lim'   => $montant_limite,
    'com'   => $commentaire,
    'lieu'  => $lieu_travail,
    'gerant'=> $nom_gerant
]);

echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
