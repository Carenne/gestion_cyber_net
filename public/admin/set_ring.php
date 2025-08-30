<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ring = intval($_POST['ring'] ?? 0);
    file_put_contents("current_ring.txt", $ring); // stocke le numéro
    echo json_encode(["status" => "ok"]);
}
