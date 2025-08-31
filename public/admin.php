<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['flash'] = 'Accès non autorisé.';
    header('Location: index.php'); exit;
}
$pv = $_GET['pv'] ?? $_SESSION['user']['point_of_sale'];
require __DIR__ . '/../inc/db.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icons.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">

    <!-- Bootstrap CSS (si pas encore inclus) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

     
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <style>
      .content-section {
        display: none;
      }
      .content-section.active {
        display: block;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="index.html"><img src="img/logo.png" alt="logo" /></a>
        </div>
        <ul class="nav d-flex">
          <li  class="nav-item profile ">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?= $pv ?></h5>
                  <span><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a> 
          </li>
          <li  class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>


          <li data-tab="index" class="nav-item menu-items tab-btn active">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Tableau de bord</span>
            </a>
          </li>

          <li data-tab="paiement" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Paiement</span>
            </a>
          </li>

          <li data-tab="bonus" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Bonus</span>
            </a>
          </li>

          <li data-tab="versement" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Versement</span>
            </a>
          </li>

          <li data-tab="wifi" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Wifi / Poste</span>
            </a>
          </li>

          <li data-tab="message" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Message</span>
            </a>
          </li>

          <li data-tab="notification" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Notification</span>
            </a>
          </li>

          <li data-tab="tarif" class="nav-item menu-items tab-btn">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Tarif</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
           
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                  <div class="navbar-profile">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-cog text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Parametre</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="logout.php" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Deconnection</p>
                    </div>
                  </a>   
                </div>
              </li>
            </ul> 
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">

            <!-- Tableau de bord -->
            <div id="index" class="content-wrapper content-section active">
                 <?php include 'admin/index-tab.php'; ?>
            </div>

            <!-- Paiement -->
            <div id="paiement" class="content-wrapper content-section">
              <h3>Paiement</h3>
              <p>Contenu paiement</p>
            </div>

            <!-- Bonus -->
            <div id="bonus" class="content-wrapper content-section">
              <h4 class="mb-3">Liste des Bonus</h4>
              <?php include 'admin/bonus_admin.php'; ?>
            </div>

            <!-- Versement -->
            <div id="versement" class="content-wrapper content-section">
              <h3>Versement</h3>
              <p>Contenu versement</p>
            </div>

            <!-- Wifi/Poste -->
            <div id="wifi" class="content-wrapper content-section">
              <h3>Wifi / Poste</h3>
              <p>Contenu wifi et poste</p>
            </div>

            <!-- Message -->
            <div id="message" class="content-wrapper content-section">
              <h3>Message</h3>
              <p>Contenu message</p>
            </div>

            <!-- Notification -->
            <div id="notification" class="content-wrapper content-section">
              <h3>Notification</h3>
              <p>Contenu notification</p>
            </div>

            <!-- Tarif -->
            <div id="tarif" class="content-wrapper content-section">
              <h3>Tarif</h3>
              <p>Contenu tarif</p>
            </div>
             
       
      </div>

          <script>

          //pagination
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
          //Fin pagination

            function sendRing(num) {
              fetch("admin/set_ring.php", {
                method: "POST",
                body: new URLSearchParams({ring: num}),
                headers: {"Content-Type": "application/x-www-form-urlencoded"}
              }).then(res => res.json())
                .then(data => console.log("Sonnerie envoyée", data));
            }
          </script>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
           
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/proBanner.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


                <script>
                    function chargerPaiements() {
                        $.get("admin/paiement-encours/get_paiements.php", function(data) { 
                            let paiements = JSON.parse(data);
                            let rows = "";

                            if (paiements.length > 0) {
                                
                                paiements.forEach(p => {
                                    rows += `
                                        <tr data-id="${p.id}">
                                            <td>${p.montant}</td>
                                            <td>${p.type_service}</td>
                                            <td>${p.commentaire}</td>
                                            <td>${p.nom_vendeur}</td>
                                            <td>${p.date_heure_paiement}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary btn-modifier">Réclamer</a><br>
                                                <a href="#" class="btn btn-sm btn-outline-danger btn-valider">Valider</a>
                                            </td>
                                        </tr>
                                    `;
                                }); 
                            } else {
                                
                                rows = `<tr><td colspan="6" class="text-center">Aucun paiement trouvé</td></tr>`;
                            }
                            
                            $("#paiementBody").html(rows);
                            
                        });
                    }

                    // Charger toutes les 2 secondes
                    setInterval(chargerPaiements, 2000);
                    chargerPaiements(); // premier chargement

                    // Validation d’un paiement
                    $(document).on("click", ".btn-valider", function(e) {
                        e.preventDefault();
                        let row = $(this).closest("tr");
                        let id = row.data("id");

                        $.post("admin/paiement-encours/valider_paiement.php", {id: id}, function(response) {
                            let res = JSON.parse(response);
                            if (res.success) {
                                row.fadeOut(500, function() { $(this).remove(); });
                            } else {
                                alert("Erreur lors de la validation.");
                            }
                        });
                    });
            </script>


             <script>
                    function chargerPaiements2() {
                        $.get("admin/paiement-encours/get_paiements2.php", function(data) { 
                            let paiements2 = JSON.parse(data);
                            let rows = "";

                            if (paiements2.length > 0) {
                                
                                paiements2.forEach(p => {
                                    rows += `
                                        <tr data-id="${p.id}">
                                            <td>${p.montant}</td>
                                            <td>${p.type_service}</td>
                                            <td>${p.commentaire}</td>
                                            <td>${p.nom_vendeur}</td>
                                            <td>${p.date_heure_paiement}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary btn-modifier2">Réclamer</a><br>
                                                <a href="#" class="btn btn-sm btn-outline-danger btn-valider2">Valider</a>
                                            </td>
                                        </tr>
                                    `;
                                }); 
                            } else {
                                
                                rows = `<tr><td colspan="6" class="text-center">Aucun paiement trouvé</td></tr>`;
                            }
                            
                            $("#paiementBody2").html(rows);
                            
                        });
                    }

                    // Charger toutes les 2 secondes
                    setInterval(chargerPaiements2, 2000);
                    chargerPaiements2(); // premier chargement

                    // Validation d’un paiement
                    $(document).on("click", ".btn-valider2", function(e) {
                        e.preventDefault();
                        let row = $(this).closest("tr");
                        let id = row.data("id");

                        $.post("admin/paiement-encours/valider_paiement2.php", {id: id}, function(response) {
                            let res = JSON.parse(response);
                            if (res.success) {
                                row.fadeOut(500, function() { $(this).remove(); });
                            } else {
                                alert("Erreur lors de la validation.");
                            }
                        });
                    });
            </script>

          <!--total versement--->
      <script>
                //Mini
                  function loadTotalMini() {
                      $.post("vendeur/paiement/total_paiement.php", { pointVente: "Mini-croc" }, function (res) {
                          let total = res.total || 0;
                          $('#TotalMn').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  function loadTotalMiniPure() {
                      $.post("vendeur/paiement/total_paiement_pure.php", { pointVente: "Mini-croc" }, function (res) {
                          let total = res.total || 0;
                          $('#Total_pureMn').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }

                  function loadBonusMin() {
                      $.post("bonus/bonus_data.php", { pointVente: "Mini-croc" }, function(res) {
                          let total = res.totalBonus || 0;
                           $('#Total_bonusMn').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  //tok
                    //Mini
                  function loadTotalTok() {
                      $.post("vendeur/paiement/total_paiement.php", { pointVente: "Tok" }, function (res) {
                          let total = res.total || 0;
                          $('#TotalTok').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
                  function loadTotalTokPure() {
                      $.post("vendeur/paiement/total_paiement_pure.php", { pointVente: "Tok" }, function (res) {
                          let total = res.total || 0;
                          $('#Total_pureTok').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }

                  function loadBonusTok() {
                      $.post("bonus/bonus_data.php", { pointVente: "Tok" }, function(res) {
                          let total = res.totalBonus || 0;
                           $('#Total_bonusTok').html(total.toLocaleString('fr-FR') + " Ar (Total)");
                      }, 'json');
                  }
           
                  //Fin Tok
               
                  // Au chargement de la page et toutes les 2 secondes
                  window.onload = function() {
                      loadTotalMini();
                      loadTotalMiniPure();
                      loadBonusMin();
                      loadTotalTok();
                      loadTotalTokPure();
                      loadBonusTok();

                      setInterval(loadTotalMini, 2000);
                      setInterval(loadTotalMiniPure, 2000);
                      setInterval(loadBonusMin, 2000);
                      setInterval(loadTotalTok, 2000);
                      setInterval(loadTotalTokPure, 2000);
                      setInterval(loadBonusTok, 2000);
                  };
       
            </script>
      
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadBonus(statut = "") {
    $.get('admin/load_bonus.php', {statut: statut}, function(data) {
        $('#bonusContent').html(data);
    });
}

// Charger tous au début


// Filtrage au clic
$('.filter-btn').click(function() {
    let statut = $(this).data('statut');
    loadBonus(statut);

    // Mise à jour de la classe active
    $('.filter-btn').removeClass('active');
    $(this).addClass('active');
});

loadBonus();

$(document).ready(function() {
    // Bouton pour changer le statut
    $(document).on('click', '.toggleStatutBtn', function(){
        let id = $(this).data('id');
        let statut = $(this).data('statut');

        $.ajax({
            url: 'admin/update_bonus.php',
            type: 'POST',
            data: { id: id, statut: statut },
            success: function(response){
                let res = JSON.parse(response);
                if(res.status === 'success'){
                    // Recharger la table
                    //$('#bonusTable').DataTable().ajax.reload(null, false); // false = garder la page actuelle
                    loadBonus('non decaissé');
                } else {
                    alert('Erreur lors de la mise à jour');
                }
            }
        });
    });
});
</script>

  </body>
</html>