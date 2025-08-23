<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    $_SESSION['flash'] = 'Accès non autorisé.';
    header('Location: index.php'); exit;
}
$pv = $_GET['pv'] ?? $_SESSION['user']['point_of_sale'];

require __DIR__ . '/../inc/db.php';
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Vendeur</title>
       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS pour Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <style>
        .tab-btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            border: none;
            background-color: #f8f9fa;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .tab-btn.active {
            background-color: #6c757d;
            color: white;
        }
        .content-section {
            display: none;
            padding: 20px;
            background: white;
            border: 1px solid #dee2e6;
        }
        .content-section.active {
            display: block;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: white;
            border-bottom: 1px solid #dee2e6;
        }
        .notif-icon {
            position: relative;
            margin-left: 15px;
            cursor: pointer;
        }
        .notif-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }
    </style>
   
</head>
<body class="bg-light">
    <!-- Barre du haut -->
    <div class="topbar">
       
        <div class="d-flex align-items-center">
            <img src="img/logo.JPG" alt="Lgo" height="40" class="me-2">
        </div>
         <div class="d-flex align-items-center">
            <h3 class="mb-0"><?= htmlspecialchars($pv) ?></h3>
        </div>
        
        <div class="d-flex align-items-center">
            <div class="notif-icon">
                <span class="bi bi-bell" style="font-size:20px;"></span>
                <span class="notif-badge">3</span>
            </div>
            <div class="notif-icon">
                <span class="bi bi-envelope" style="font-size:20px;"></span>
            </div>
               <!-- Dans la barre du haut -->
            <div class="notif-icon dropdown">
                <span id="profileIcon" class="bi bi-person-circle" style="font-size:24px; cursor:pointer;" data-bs-toggle="dropdown"></span>
                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="profileIcon" style="min-width:250px;">
                    <li class="text-center">
                      
                        <div><strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></div>
                       
                        <div class="mt-2 badge bg-secondary"><?= $pv ?></div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="settings.php">
                            <i class="bi bi-gear"></i> Gestion de Bonus
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="mouvement_argent.php">
                            <i class="bi bi-gear"></i> Mouvement Argent
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="settings.php">
                            <i class="bi bi-gear"></i> Tarif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Se déconnecter
                            
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="container w-75 mt-4">
      <!-- Boutons onglets -->
      <div class="d-flex">
          <button class="tab-btn active" data-tab="mvn">MOUVEMENT ARGENT</button>
   
      </div>

      <div id="mvn" class="content-section">
            <P>TOTAL ARGENT RECU (versement et bonus)</p>
          <P>VERSEMENT PURE SANS BONUS</p>
          <P>TOTAL BONUS</p>
          <P>TOTAL ARGENT SORTIE</p>
          <P>TOTAL TROSA NON RECU</p>
          <P>TOTAL PAIEMENT PAR MVOLA</p>
          <P>TOTAL ARGENT BRUTE PRESENT</p>
          <P>CRUD ARGENT SORTI, TROSA, PAYEMENT PAR MVOLA</p>
      </div>
    </div>

   
    <script>
           const buttons = document.querySelectorAll('.tab-btn');
        const sections = document.querySelectorAll('.content-section');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Retirer active de tous les boutons
                buttons.forEach(b => b.classList.remove('active'));
                // Ajouter active au bouton cliqué
                btn.classList.add('active');

                // Masquer tous les contenus
                sections.forEach(sec => sec.classList.remove('active'));
                // Afficher le contenu correspondant
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

    </script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    


</body>
</html>

