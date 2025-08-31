<?php
require_once __DIR__ . '/../../inc/db.php';

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    // Récupérer la dernière sonnerie pour ce user
    $stmt = $pdo->prepare("SELECT * FROM rings WHERE target = :user ORDER BY id DESC LIMIT 1");
    $stmt->execute([':user' => $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Supprimer la sonnerie une fois récupérée
        $del = $pdo->prepare("DELETE FROM rings WHERE id = :id");
        $del->execute([':id' => $row['id']]);

        echo json_encode([
            "ring" => true,
            "file" => $row['ringfile']
        ]);
    } else {
        echo json_encode(["ring" => false]);
    }
} else {
    echo json_encode(["ring" => false, "error" => "Paramètre 'user' manquant"]);
}
