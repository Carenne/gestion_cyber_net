<?php
// wifi_get_today.php
session_start();
require __DIR__ . '/../../../inc/db.php';

$pointVente = $_GET['pointVente'] ?? null;

if ($pointVente) {
    $sql = "SELECT * FROM wifi WHERE lieu_travail = :pointVente ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pointVente' => $pointVente]);
} else {
    // fallback : si aucun pointVente envoyé, on prend tout
    $stmt = $pdo->query("SELECT * FROM wifi ORDER BY id DESC");
}

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);