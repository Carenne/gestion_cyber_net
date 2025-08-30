<?php
header("Content-Type: application/json");
$ring = 0;

if (file_exists("current_ring.txt")) {
    $ring = intval(file_get_contents("current_ring.txt"));
    if ($ring > 0) {
        // Réinitialiser après lecture pour éviter de rejouer en boucle
        file_put_contents("current_ring.txt", 0);
    }
}

echo json_encode(["ring" => $ring]);
