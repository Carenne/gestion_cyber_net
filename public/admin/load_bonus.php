<?php
require_once __DIR__ . '/../../inc/db.php'; // Connexion PDO

// Vérifier si un filtre est demandé (GET ?statut=decaissé)
$where = "";
$params = [];
if (!empty($_GET['statut'])) {
    $where = "WHERE statut = :statut";
    $params[':statut'] = $_GET['statut'];
}

$sql = "SELECT id, id_paiement, montant_bonus, date_enregistrement, nom_point_vente, statut 
        FROM bonus 
        $where 
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>

<table id="bonusTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Paiement</th>
            <th>Montant Bonus</th>
            <th>Date d'enregistrement</th>
            <th>Nom Point de Vente</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['id_paiement']) ?></td>
                <td class="montant"><?= htmlspecialchars($row['montant_bonus']) ?></td>
                <td><?= htmlspecialchars($row['date_enregistrement']) ?></td>
                <td><?= htmlspecialchars($row['nom_point_vente']) ?></td>
                <td>
                    <?php if ($row['statut'] === 'decaissé'): ?>
                        <span class="badge bg-success">Décaisé</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Non Décaisé</span>
                        <button class="btn btn-sm btn-danger toggleStatutBtn" data-id="<?= $row['id'] ?>" data-statut="decaissé">Passer en Décaisé</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="text-align:right">Total :</th>
            <th id="totalMontant">0</th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>


            <script>
$(document).ready(function() {
    $('#bonusTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "footerCallback": function(row, data, start, end, display) {
            let api = this.api();

            // Calculer le total sur toutes les lignes visibles
            let total = api
                .column(2, { page: 'current' }) // colonne Montant Bonus (index 2)
                .data()
                .reduce(function(a, b) {
                    // retirer les séparateurs si nécessaire et convertir en nombre
                    let x = typeof a === 'string' ? a.replace(/[^0-9.-]/g, '')*1 : a;
                    let y = typeof b === 'string' ? b.replace(/[^0-9.-]/g, '')*1 : b;
                    return x + y;
                }, 0);

            // Mettre à jour le footer
            $('#totalMontant').html(total.toLocaleString('fr-FR') + ' Ar');
        }
    });
});
</script>


                    <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

            <script>
         /*   $(document).ready(function() {
                $('#bonusTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                    }
                });
            });*/
            </script>
            

