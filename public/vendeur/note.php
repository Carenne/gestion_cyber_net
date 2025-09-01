   
      <div id="note" class="content-section active">
            <?php
                // Récupération des paiements
              $pointVente = htmlspecialchars($pv);
              
              // Remplace par la valeur réelle

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
     

            <!-- Montant par type -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Enregistrement paiement</h5>
                </div>
                <div class="card-body">

                        <div class="row align-items-center">
                            <!-- Montant -->
                            <div class="col-md-6">
                                <label for="montant" class="form-label">Montant</label>
                                <input type="text" id="montant" name="montant" class="form-control" readonly>
                            </div>

                            <!-- Commentaire -->
                            <div class="col-md-6">
                                <label for="commentaire" class="form-label">Commentaire</label>
                                <textarea class="form-control" rows="1" id="commentaire" name="commentaire" placeholder="Saisissez votre commentaire ici..."></textarea>
                            </div>
                        </div>
                        <div id="alertBox" class="col-12">
                            <!-- Message d'alerte ici -->
                        </div>
  
                                        <!--Choix type de service-->
                        <div class="container-fluid mt-3">
                        <div class="row">
                            <!-- Colonne 1 -->
                            <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="posteCheck">
                                <label class="form-check-label" for="posteCheck">(P)Poste</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="Wifi-CableCheck">
                                <label class="form-check-label" for="Wifi-CableCheck">(W)Wifi/Cable</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="MarchandiseCheck">
                                <label class="form-check-label" for="MarchandiseCheck">(M)Marchandise (Envellope ...)</label>
                            </div>
                             <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ReliureCheck">
                                <label class="form-check-label" for="ReliureCheck">(R)Reliure</label>
                            </div>
                            </div>

                            <!-- Colonne 2 -->
                            <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="Impression-PhotocopieCheck">
                                <label class="form-check-label" for="Impression-PhotocopieCheck">
                                (I)Impression/Photocopie/scan (manasa sary ...)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="PlastificationCheck">
                                <label class="form-check-label" for="PlastificationCheck">(L)Plastification</label>
                            </div>
                            
                             <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="EmailCheck">
                                <label class="form-check-label" for="EmailCheck">(E)Email (Envoi/reçois)</label>
                            </div>
                           

                            
                            </div>

                            <!-- Colonne 3 -->
                            <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="FilmCheck">
                                <label class="form-check-label" for="FilmCheck">(F)Film</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="SaisieCheck">
                                <label class="form-check-label" for="SaisieCheck">(S)Saisie</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ApplicationCheck">
                                <label class="form-check-label" for="ApplicationCheck">(A)Application</label>
                            </div>
                            </div>

                            <!-- Colonne 4 -->
                            <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="Mise-a-jourCheck">
                                <label class="form-check-label" for="Mise-a-jourCheck">(J)Mise à jour</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="Installation-systemeCheck">
                                <label class="form-check-label" for="Installation-systemeCheck">(N)Installation système</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="AutreCheck">
                                <label class="form-check-label" for="AutreCheck">(O)Autre</label>
                            </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener("keydown", function(event) {
                                let key = event.key.toLowerCase(); // on met en minuscule pour éviter la différence P / p

                                // dictionnaire lettre → id du checkbox
                                const mapping = {
                                    "p": "posteCheck",
                                    "w": "Wifi-CableCheck",
                                    "m": "MarchandiseCheck",
                                    "r": "ReliureCheck",
                                    "i": "Impression-PhotocopieCheck",
                                    "l": "PlastificationCheck",
                                    "e": "EmailCheck",
                                    "f": "FilmCheck",
                                    "s": "SaisieCheck",
                                    "a": "ApplicationCheck",
                                    "j": "Mise-a-jourCheck",
                                    "n": "Installation-systemeCheck",
                                    "o": "AutreCheck"
                                };

                                if (mapping[key]) {
                                    let checkbox = document.getElementById(mapping[key]);
                                    if (checkbox) {
                                        checkbox.checked = !checkbox.checked; // toggle (coche/décoche)
                                    }
                                }
                            });
                        </script>

                        </div>





                    <!-- Tableau des montants -->
                                        
                    <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('1')">1</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('2')">2</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('3')">3</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('4')">4</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('5')">5</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('6')">6</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('7')">7</button></td>
                                        <td><button class="btn btn-danger w-100" onclick="effacerDernier()">Effacer</button></td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('8')">8</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('9')">9</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('0')">0</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('00')">00</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('100')">100</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('200')">200</button></td>
                                        <td><button class="btn btn-light w-100" onclick="ajouterValeur('1000')">1000</button></td>
                                        <td><button class="btn btn-primary w-100" id="btnEnregistrer"><i class="bi bi-save me-2"></i>Enregistrer</button></td>
                                    </tr>
                                </tbody>
                            </table>

                    </div>
                    <script>
                        const montantInput = document.getElementById("montant");
                        const btnEnregistrer = document.getElementById("btnEnregistrer");

                        // Ajouter une valeur dans le champ Montant
                        function ajouterValeur(val) {
                            montantInput.value += val;
                        }

                        // Effacer le dernier caractère
                        function effacerDernier() {
                            montantInput.value = montantInput.value.slice(0, -1);
                        }

                        // Gérer les touches clavier
                        document.addEventListener("keydown", function(event) {
                            const key = event.key; // touche appuyée

                            // Si c'est un chiffre (0-9)
                            if (/^[0-9]$/.test(key)) {
                                ajouterValeur(key);
                            }

                            // Si c'est "Backspace" ou "Delete"
                            if (key === "Backspace" || key === "Delete") {
                                effacerDernier();
                            }

                            // Si c'est "Enter"
                            if (key === "Enter") {
                                btnEnregistrer.click(); // simule un clic sur le bouton
                            }
                        });
                    </script>

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
               <!-- <button id="btnTotal" class="px-4">
                        <h2>TOTAL VERSEMENT : 0 Ar</h2>
                </button>-->
            <!-- Boîte d'alerte -->

                
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
            if (document.getElementById('Wifi-CableCheck').checked) services.push('Wifi/Cable');

            if (document.getElementById('Impression-PhotocopieCheck').checked) services.push('Impression-Photocopie-scan');
            if (document.getElementById('ReliureCheck').checked) services.push('Reliure');
            if (document.getElementById('PlastificationCheck').checked) services.push('Plastification');
            if (document.getElementById('MarchandiseCheck').checked) services.push('Marchandise ');
            if (document.getElementById('EmailCheck').checked) services.push('Email');
            if (document.getElementById('FilmCheck').checked) services.push('Film');
            if (document.getElementById('SaisieCheck').checked) services.push('Saisie');
            if (document.getElementById('ApplicationCheck').checked) services.push('Application');
            if (document.getElementById('Mise-a-jourCheck').checked) services.push('Mise a jour');
            if (document.getElementById('Installation-systemeCheck').checked) services.push('Installation systeme');
            if (document.getElementById('AutreCheck').checked) services.push('Autre');
            

            let type_service = services.join(', ');

     

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
                         // Afficher message succès
                        $('#alertBox2').html(`
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Misafidiana service ray, ary aza hadino ny prix!
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
                    <!-- Colonne 1 -->
                    <option value="Poste">Poste</option>
                    <option value="Wifi/Cable">Wifi/Cable</option>

                    <!-- Colonne 2 -->
                    <option value="Impression/Photocopie/scan">Impression/Photocopie/scan (manasa sary ...)</option>
                    <option value="Plastification">Plastification</option>
                    <option value="Reliure">Reliure</option>
                    <option value="Marchandise">Marchandise (Envellope ...)</option>
                    <option value="Email">Email (Envoi/reçois)</option>

                    <!-- Colonne 3 -->
                    <option value="Film">Film</option>
                    <option value="Saisie">Saisie</option>
                    <option value="Application">Application</option>
                    <option value="Mise a jour">Mise a jour</option>
                    <option value="Installation systeme">Installation systeme</option>
                    <option value="Autre">Autre</option>
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

