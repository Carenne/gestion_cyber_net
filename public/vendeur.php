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
          <button class="tab-btn active" data-tab="note">NOTE VERSEMENT</button>
        
          <button class="tab-btn" data-tab="wifi">CONTROLE WIFI</button>
      </div>

      <!-- Contenus -->
     <?php include 'vendeur/note.php'; ?>

  
      <div id="wifi" class="content-section">
             <?php include 'vendeur/wifi.php'; ?>
      </div>
    </div>

 <script>

        function loadTotal() {
            $.post("vendeur/paiement/total_paiement.php", { pointVente: "<?= $pointVente ?>" }, function (res) {
                let total = res.total || 0;

                 // Met à jour le <tfoot>
                $('#totalCell').text(total.toLocaleString('fr-FR') + ' Ar');

                // Met à jour le bouton
                $('#btnTotal').html("<h2>TOTAL VERSEMENT : " + total.toLocaleString('fr-FR') + " Ar</h2>");
                }, 'json');
        }

            $(document).ready(function() {
                // Charger total dès le départ
                    loadTotal();
            });
                            
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


        //cofirmer suppression
                   // Quand on confirme dans la modale
            $("#confirmerSuppression").on("click", function() {
                
                let cause = $("#causeSuppression").val().trim();

                if (cause === "") {
                    $("#erreurSuppression").text("Veuillez indiquer la cause de la suppression.");
                    return;
                }

                $.post("vendeur/paiement/supprimer_paiement.php", { id: paiementId, cause: cause }, function (response) {
                    if (response.success) {
                        $("tr[data-id='" + paiementId + "']").remove();
                        $("#modalSuppression").modal("hide");
                        loadTotal();
                    } else {
                        $("#erreurSuppression").text(response.message);
                    }
                }, "json");
            });

        
        // Quand on confirme la modification
            $("#confirmerModification").on("click", function() {
                let id = $("#modifPaiementId").val();
                let montant = $("#modifMontant").val().trim();
                let type_service = $("#modifTypeService").val().trim();
                let commentaire = $("#modifCommentaire").val().trim();
                let justification = $("#justificationModification").val().trim();

                if (justification === "") {
                    $("#erreurModification").text("Veuillez indiquer la justification.");
                    return;
                }

                $.post("vendeur/paiement/modifier_paiement.php", {
                    id: id,
                    montant: montant,
                    type_service: type_service,
                    commentaire: commentaire,
                    justification: justification
                }, function(response) {
                    if (response.success) {
                        // Met à jour la ligne dans le tableau
                        let row = $("tr[data-id='" + id + "']");
                        row.find("td:eq(0)").text(montant);
                        row.find("td:eq(1)").text(type_service);
                        row.find("td:eq(2)").text(commentaire);

                        $("#modalModification").modal("hide");
                        loadTotal();
                    } else {
                        $("#erreurModification").text(response.message);
                    }
                }, "json");
            });




            const pointVente = "<?php echo htmlspecialchars($pv); ?>";

            function refreshTable() {
            $.getJSON('vendeur/wifi/liste_wifi.php', { pointVente: pointVente }, function(data) {
                let rows = '';
                data.forEach(function(item) {
                    let actionButton = '';

                    if (item.heure_demarrage === item.heure_fin) {
                        // connexion en cours
                        actionButton = `
                            <button class="btn btn-sm btn-secondary" onclick="stopWifi(${item.id})">
                                Stop
                            </button>
                        `;
                    } else {
                        // connexion déjà stoppée
                        actionButton = `
                            <button class="btn btn-sm btn-danger" onclick="supprimerWifi(${item.id})">
                                Supprimer
                            </button>
                        `;
                    }

                    rows += `
                        <tr>
                            <td>${item.heure_demarrage}</td>
                            <td>${item.heure_fin}</td>
                            <td>${item.temps} min</td>
                            <td>${item.prix} Ar</td>
                            <td>${item.montant_limite ?? ''} Ar</td>
                            <td>${item.commentaire ?? ''}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" 
                                    onclick="ouvrirModifierWifi(${item.id}, '${item.montant_limite}', '${item.commentaire ?? ''}')">
                                    Modifier
                                </button>
                                ${actionButton}
                            </td>
                        </tr>
                    `;
                });
                $('#wifiBody').html(rows);
            });
        }



            // Charger au démarrage
            refreshTable();

            // Recharger toutes les 30 secondes
            setInterval(refreshTable, 30000);

            ////////////Ajout/////////////////
            $(document).ready(function() {
                // Soumission du formulaire
                $('#addWifiForm').on('submit', function(e) {
                    e.preventDefault(); // Empêche le rechargement de la page

                    $.ajax({
                        url: 'vendeur/wifi/ajouter_wifi.php', // ton fichier PHP
                        type: 'POST',
                        data: $(this).serialize(), // envoie toutes les données du formulaire
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Fermer la modale
                                $('#addWifiModal').modal('hide');

                                // Recharger la table
                                refreshTable();

                                // Message de succès (optionnel)
                                alert('Connexion ajoutée avec succès ✅');
                            } else {
                                alert('Erreur : ' + (response.message || response.error));
                            }
                        },
                        error: function() {
                            alert('Erreur lors de l\'ajout.');
                        }
                    });
                });
            });



            ////////////////Modification
            function ouvrirModifierWifi(id, montant, commentaire) {
                $('#edit_id').val(id);
                $('#edit_montant_limite').val(montant);
                $('#edit_commentaire').val(commentaire);
                $('#editWifiModal').modal('show');
            }

            // Quand on soumet le formulaire
            $('#editWifiForm').submit(function(e) {
                e.preventDefault();
                $.post('vendeur/wifi/modifier_wifi.php', $(this).serialize(), function(response) {
                    let res = JSON.parse(response);
                    if (res.success) {
                        $('#editWifiModal').modal('hide');
                        refreshTable();
                    } else {
                        alert(res.error || "Erreur lors de la modification");
                    }
                });
            });



            function stopWifi(id) {
                if (!confirm("Voulez-vous vraiment arrêter cette connexion ?")) return;

                $.post('vendeur/wifi/stop_wifi.php', { id: id }, function(response) {
                    if (response.success) {
                        refreshTable();
                    } else {
                        alert("Erreur : " + response.message);
                    }
                }, 'json');
            }



            function supprimerWifi(id) {
                if (!confirm("Voulez-vous vraiment supprimer cet enregistrement ?")) return;

                $.post('vendeur/wifi/supprimer_wifi.php', { id: id }, function(response) {
                    if (response.success) {
                        refreshTable(); // recharge le tableau après suppression
                    } else {
                        alert("Erreur : " + response.message);
                    }
                }, 'json');
            }


            function supprimerWifi(id) {
                if (!confirm("Voulez-vous vraiment supprimer cet enregistrement ?")) return;

                $.post('vendeur/wifi/supprimer_wifi.php', { id: id }, function(response) {
                    if (response.success) {
                        refreshTable(); // recharge le tableau après suppression

                        // Afficher le toast
                        const toastEl = document.getElementById('toastSuppression');
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    } else {
                        alert("Erreur : " + response.message);
                    }
                }, 'json');
            }


</script>
    

       

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    


</body>
</html>

