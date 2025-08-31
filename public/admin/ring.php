<?php
require_once __DIR__ . '/../../inc/db.php';

if (isset($_POST['target']) && isset($_POST['ringfile'])) {
    $t  = $_POST['target'];
    $rf = $_POST['ringfile'];

    $stmt = $pdo->prepare("INSERT INTO rings (target, ringfile) VALUES (:target, :ringfile)");
    $stmt->execute([
        ':target'   => $t,
        ':ringfile' => $rf
    ]);

    echo "Insertion réussie : $t - $rf";
} else {
    echo "Paramètres manquants.";
}
