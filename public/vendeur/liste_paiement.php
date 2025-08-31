   <!-- Liste des paiements -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Liste des paiements</h5>
                </div>
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
                                                    <a href="#" class="btn btn-sm btn-outline-primary btn-modifier">Modifier</a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger btn-supprimer">Supprimer</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end">TOTAL VERSEMENT :</th>
                                        <th id="totalCell">0 Ar</th>
                                    </tr>
                                </tfoot>
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