<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendeur') {
    $_SESSION['flash'] = 'Accès non autorisé.';
    header('Location: index.php'); exit;
}
$pv = $_GET['pv'] ?? $_SESSION['user']['point_of_sale'];


?>
<?php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'db_cyber';
$DB_USER = 'root';
$DB_PASS = '';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    die('Connexion DB échouée : ' . $e->getMessage());
}


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
                        <img src="avatar.jpg" alt="Avatar" class="rounded-circle mb-2" width="50" height="50">
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
          <button class="tab-btn active" data-tab="note">NOTE VERSEMENT</button>
          <button class="tab-btn" data-tab="poste">CONTROLE POSTE</button>
          <button class="tab-btn" data-tab="wifi">CONTROLE WIFI</button>
      </div>

      <!-- Contenus -->
        
      <div id="note" class="content-section active">
            <?php
                // Récupération des paiements
                $stmt = $pdo->query("SELECT * FROM paiement ORDER BY date_heure_paiement DESC");
                $paiements = $stmt->fetchAll();
            ?>
            <!-- Liste des paiements -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Liste des paiements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                       <!-- <table class="table table-striped mb-0">-->
                         <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Montant</th>
                                    <th>Type</th>
                                    <th>Commentaire</th>
                                    <th>Vendeur</th>
                                    <th>Heure</th>
                                    <th>Contrôle</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (!empty($paiements)): ?>
                                    <?php foreach ($paiements as $p): ?>
                                        <tr>
                                            
                                            <td><?= htmlspecialchars($p['montant']) ?></td>
                                            <td><?= htmlspecialchars($p['type_service']) ?></td>
                                            <td><?= htmlspecialchars($p['commentaire']) ?></td>
                                            <td><?= htmlspecialchars($p['nom_vendeur']) ?></td>
                                            <td><?= htmlspecialchars($p['date_heure_paiement']) ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Modifier</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun paiement trouvé</td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                            <script>
                                $(document).ready(function () {
                                    $('#myTable').DataTable({
                                        "pageLength": 5, // Par défaut 5 lignes par page
                                        "lengthMenu": [5, 10, 25, 50, 100], // Choix possible
                                        "language": {
                                            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
                                        }
                                    });
                                });
                            </script>
                    </div>
                </div>
            </div>

            <!-- Montant par type -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Enregistrement paiement</h5>
                </div>
                <div class="card-body">

                    <!--Motant-->
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="text" id="montant" name="montant" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="Saisissez votre commentaire ici..."></textarea>
                    </div>


                    <!--Choix type de service-->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="posteCheck">
                                <label class="form-check-label" for="posteCheck">Poste</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="impressionCheck">
                                <label class="form-check-label" for="impressionCheck">Impression/Photocopie</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="wifiCheck">
                                <label class="form-check-label" for="wifiCheck">Wifi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="filmCheck">
                                <label class="form-check-label" for="filmCheck">Film</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="autreCheck">
                                <label class="form-check-label" for="autreCheck">Autre</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tableau des montants -->
                                        
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody>
                                <tr>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('200')">200</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('300')">300</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('400')">400</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('500')">500</button></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('7')">7</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('8')">8</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('9')">9</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('600')">600</button></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('4')">4</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('5')">5</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('6')">6</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('700')">700</button></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('1')">1</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('2')">2</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('3')">3</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('900')">900</button></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('0')">0</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('00')">00</button></td>
                                    <td><button class="btn btn-danger w-100" onclick="effacerDernier()">Effacer</button></td>
                                    <td><button class="btn btn-light w-100" onclick="ajouterValeur('1800')">1800</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <script>
                        function ajouterValeur(val) {
                            const champ = document.getElementById('montant');
                            champ.value += val;
                        }

                        function effacerDernier() {
                            const champ = document.getElementById('montant');
                            champ.value = champ.value.slice(0, -1);
                        }
                    </script>
                </div>
            </div>

            <!-- Bouton Enregistrer -->
            <div class="text-end">
                <button class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Enregistrer
                </button>
            </div>
        </div>

      <div id="poste" class="content-section">
          <h4>POSTE AFFICHAGE</h4>
          <p>Contenu des postes ici...</p>
      </div>
      <div id="wifi" class="content-section">
          <h4>WIFI AFFICHAGE</h4>
          <p>Contenu des informations WiFi ici...</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

