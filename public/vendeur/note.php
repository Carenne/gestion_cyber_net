   
      <div id="note" class="content-section active">
            <?php
                // Récupération des paiements
              $pointVente = htmlspecialchars($pv); // Remplace par la valeur réelle

                $stmt = $pdo->prepare("
                    SELECT * 
                    FROM paiement 
                    WHERE DATE(date_heure_paiement) = CURDATE() 
                    AND nom_point_vente = :pointVente
                    ORDER BY date_heure_paiement DESC
                ");

                $stmt->execute(['pointVente' => $pointVente]);
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

                                <?php
                                    if (!empty($paiements)): 
                                ?>
                                    <?php foreach ($paiements as $p): 
                                    ?>
                                       <tr data-id="<?= $p['id'] ?>">
                                            <td><?= htmlspecialchars($p['montant']) ?></td>
                                            <td><?= htmlspecialchars($p['type_service']) ?></td>
                                            <td><?= htmlspecialchars($p['commentaire']) ?></td>
                                            <td><?= htmlspecialchars($p['nom_vendeur']) ?></td>
                                            <td><?= htmlspecialchars($p['date_heure_paiement']) ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary btn-modifier">Modifier</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger btn-supprimer">Supprimer</a>
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
            
          <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Boîte d'alerte -->
                <div id="alertBox" class="me-3 flex-grow-1">
                <!-- Message d'alerte ici -->
                </div>

                <!-- Bouton Enregistrer -->
                <button id="btnEnregistrer" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Enregistrer
                </button>
            </div>
            </div>
            
        </div>

         
    <script>
        document.getElementById('btnEnregistrer').addEventListener('click', function () {
            // Récupérer les valeurs du formulaire
            let montant = document.getElementById('montant').value.trim();
            let commentaire = document.getElementById('commentaire').value.trim();

            // Récupérer tous les checkbox cochés et joindre les valeurs par virgule
            let services = [];
            if (document.getElementById('posteCheck').checked) services.push('Poste');
            if (document.getElementById('impressionCheck').checked) services.push('Impression/Photocopie');
            if (document.getElementById('wifiCheck').checked) services.push('Wifi');
            if (document.getElementById('filmCheck').checked) services.push('Film');
            if (document.getElementById('autreCheck').checked) services.push('Autre');

            let type_service = services.join(', ');

            if (montant === '' || services.length === 0) {
                alert("Veuillez remplir le montant et choisir au moins un service.");
                return;
            }

                // Envoi AJAX
                $.post("vendeur/paiement/ajouter_paiement.php", {
                    montant: montant,
                    type_service: type_service,
                    commentaire: commentaire
                }, function (response) {
                     
                    let res = JSON.parse(response);

                    if (res.status === 'success') {
                        // Ajouter la nouvelle ligne dans le tableau sans recharger
                        let p = res.data;
                        let newRow = `
                            <tr>
                                <td>${p.montant}</td>
                                <td>${p.type_service}</td>
                                <td>${p.commentaire}</td>
                                <td>${p.nom_vendeur}</td>
                                <td>${p.date_heure_paiement}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Modifier</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger">Supprimer</a>
                                </td>
                            </tr>
                        `;
                        $('#myTable').DataTable().row.add($(newRow)).draw();

                        // Réinitialiser le formulaire
                        document.getElementById('montant').value = '';
                        document.getElementById('commentaire').value = '';
                        $('input[type=checkbox]').prop('checked', false);

                        // Afficher message succès
                        $('#alertBox').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Paiement enregistré avec succès !
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                            </div>
                        `);

                        // Supprimer automatiquement après 3 secondes
                        setTimeout(() => {
                            $('.alert').alert('close');
                        }, 2000);

                        loadTotal(); // Met à jour immédiatement le total

                    } else {
                        alert(res.message);
                    }
                });
      
            });


            // Suppression d’un paiement
            let paiementId = null;

            // Quand on clique sur "Supprimer"
            $(document).on("click", ".btn-supprimer", function(e) {
                e.preventDefault();
                paiementId = $(this).closest("tr").data("id");
                $("#causeSuppression").val("");
                $("#erreurSuppression").text("");
                $("#modalSuppression").modal("show");
            });
       
////////////////////////////MODEIFICATION////////////////

            let modifId = null;

            // Quand on clique sur "Modifier"
            $(document).on("click", ".btn-modifier", function(e) {
                e.preventDefault();
                let row = $(this).closest("tr");
                modifId = row.data("id");

                $("#modifPaiementId").val(modifId);
                $("#modifMontant").val(row.find("td:eq(0)").text().trim());
                $("#modifTypeService").val(row.find("td:eq(1)").text().trim());
                $("#modifCommentaire").val(row.find("td:eq(2)").text().trim());
                $("#justificationModification").val("");
                $("#erreurModification").text("");

                $("#modalModification").modal("show");
            });



    </script>


<!-- Modal de suppression -->
<div class="modal fade" id="modalSuppression" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supprimer un paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Pourquoi voulez-vous supprimer ce paiement ?</p>
        <textarea id="causeSuppression" class="form-control" rows="3" placeholder="Écrivez la cause de la suppression..."></textarea>
        <div id="erreurSuppression" class="text-danger mt-2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" id="confirmerSuppression">Supprimer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de modification -->
<div class="modal fade" id="modalModification" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier un paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formModification">
          <input type="hidden" id="modifPaiementId">
          <div class="mb-3">
            <label>Montant</label>
            <input type="text" id="modifMontant" class="form-control">
          </div>
          <div class="mb-3">
            <label for="modifTypeService" class="form-label">Type de service</label>
              <select class="form-select" id="modifTypeService" name="modifTypeService" required>
                <option value="Poste">Poste</option>
                <option value="Impression/Photocopie">Impression/Photocopie</option>
                <option value="Wifi">Wifi</option>
                <option value="Film">Film</option>
                <option value="SurveillaAutrence">Autre</option>
              </select>
          </div>
          <div class="mb-3">
            <label>Commentaire</label>
            <textarea id="modifCommentaire" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label>Justification de la modification</label>
            <textarea id="justificationModification" class="form-control"></textarea>
            <div id="erreurModification" class="text-danger mt-2"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="confirmerModification">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

