 <?php
                // Récupération des paiements
              $pointVente = htmlspecialchars($pv); // Remplace par la valeur réelle

                $stmt = $pdo->prepare("
                    SELECT * 
                    FROM wifi 
                    WHERE DATE(date_enregistrement) = CURDATE() 
                    AND lieu_travail = :pointVente
                    ORDER BY date_enregistrement DESC
                ");

                $stmt->execute(['pointVente' => $pointVente]);
                $paiements = $stmt->fetchAll();

            ?>
  <!-- Liste des paiements -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Liste Wifi/Cable</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                       <table id="tableWifi" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Heure de demarrage</th>
                                    <th>Heure fin</th>
                                    <th>Temps</th>
                                    <th>Prix</th>
                                    <th>Limite</th>
                                    <th>Nom/commentaire</th>
                                    <th>Contrôle</th>
                                </tr>
                            </thead>
                            <tbody id="wifiBody"></tbody>
                            <tfooter>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addWifiModal">
                                            Ajouter wifi/Cable
                                        </a>
                                    </td>
                                </tr>
                            </tfooter>
                        </table>
                          
                    </div>
                </div>
            </div>




<div class="modal fade" id="addWifiModal" tabindex="-1" aria-labelledby="addWifiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addWifiForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nouvelle connexion Wi-Fi / Câble</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Montant limite</label>
            <input type="number" step="0" name="montant_limite" class="form-control" value="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Commentaire</label>
            <input type="text" name="commentaire" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editWifiModal" tabindex="-1" aria-labelledby="editWifiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editWifiForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modifier connexion Wi-Fi / Câble</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3">
            <label class="form-label">Montant limite</label>
            <input type="number" step="0" name="montant_limite" id="edit_montant_limite" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Commentaire</label>
            <input type="text" name="commentaire" id="edit_commentaire" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Toast suppression -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
  <div id="toastSuppression" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Suppression réussie ✅
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
