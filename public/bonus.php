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
                        <a class="dropdown-item" href="bonus.php">
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
          <button class="tab-btn active" data-tab="mvn">GESTION DE BONUS</button>
   
      </div>

      <div id="mvn" class="content-section active">
          <?php
                $pointVente = htmlspecialchars($pv);

                $stmt = $pdo->prepare("
                      SELECT * 
                        FROM bonus 
                        WHERE nom_point_vente = :pointVente
                        AND MONTH(date_enregistrement) = MONTH(CURDATE())
                        AND YEAR(date_enregistrement) = YEAR(CURDATE())
                        ORDER BY date_enregistrement DESC
                ");

                $stmt->execute(['pointVente' => $pointVente]);
                $paiements = $stmt->fetchAll();

                /*  Calculer la somme des bonus */
                $totalBonus = array_sum(array_column($paiements, 'montant_bonus'));
            ?>

            <!-- Liste des paiements -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Liste des paiements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                       
                       
                            <table id="myTableb" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="table-light"> 
                                    <tr>
                                        <th>Montant</th>
                                        <th>Id paiement</th>
                                        <th>Date enregistrement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($paiements)): ?>
                                        <?php foreach ($paiements as $p): ?>
                                            <tr data-id="<?= $p['id'] ?>">
                                                <td><?= htmlspecialchars($p['montant_bonus']) ?></td>
                                                <td><?= htmlspecialchars($p['id_paiement']) ?></td>
                                                <td><?= htmlspecialchars($p['date_enregistrement']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Aucun BONUS trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end">
                                            TOTAL BONUS : <p id="totalCell"><?= number_format($totalBonus, 0, ',', ' ') ?> Ar</p>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>


                            <script>
                                /*$(document).ready(function () {
                                    $('#myTableb').DataTable({
                                        "pageLength": 5, // Par défaut 5 lignes par page
                                        "lengthMenu": [5, 10, 25, 50, 100], // Choix possible
                                        "language": {
                                            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
                                        }
                                    });
                                });*/
                            </script>
                    </div>
                </div>
            </div>
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

