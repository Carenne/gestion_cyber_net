<div class="d-flex justify-content-center align-items-center" style="height:100px;">
  <h4>PAIEMENT ENCOURS TOK</h4>
</div>

       <?php
                // Récupération des paiements
              $pointVente = 'Tok';
              
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
            <!-- Liste des paiements -->
            <div class="card mb-4">
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                       
                       
                    
                        <table id="myTable2" class="table table-striped table-bordered table-hover" style="width:100%">
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
                            <tbody id="paiementBody2">
                                <tr><td colspan="6" class="text-center">Chargement...</td></tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>