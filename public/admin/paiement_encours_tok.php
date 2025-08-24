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
                                            <tr data-id="<?= $p['id'] ?>">
                                                <td><?= htmlspecialchars($p['montant']) ?></td>
                                                <td><?= htmlspecialchars($p['type_service']) ?></td>
                                                <td><?= htmlspecialchars($p['commentaire']) ?></td>
                                                <td><?= htmlspecialchars($p['nom_vendeur']) ?></td>
                                                <td><?= htmlspecialchars($p['date_heure_paiement']) ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-primary btn-modifier">Réclamer</a><br>
                                                    <a href="#" class="btn btn-sm btn-outline-danger btn-supprimer">Valider</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>

                    </div>
                </div>
            </div>