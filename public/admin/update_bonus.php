<?php
require_once __DIR__ . '/../../inc/db.php';

if(!empty($_POST['id']) && !empty($_POST['statut'])){
    $sql = "UPDATE bonus SET statut = :statut WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([':statut'=>$_POST['statut'], ':id'=>$_POST['id']])){
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error']);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Données manquantes']);
}
