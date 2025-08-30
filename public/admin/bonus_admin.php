<div class="mb-3">
    <button class="btn btn-secondary filter-btn" data-statut="">Tous</button>
    <button class="btn btn-success filter-btn" data-statut="decaissé">Décaisé</button>
    <button class="btn btn-warning filter-btn" data-statut="non decaissé">Non Décaisé</button>
</div>

<!-- Zone où le tableau sera chargé -->
<div id="bonusContent"></div>

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

loadBonus('');


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

<script>
</script>