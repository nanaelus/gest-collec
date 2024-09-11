<div class="row row-cols-md-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <?php
                $totalUsers = array_sum(array_column($infosUser,'count'));
                ?>
                <h4 class="card-title">Utilisateurs ( <?= $totalUsers ?> )</h4>
            </div>
            <div class="card-body">
                <canvas id="userPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Convertir le tableau PHP en un objet JavaScript
    var data = <?php echo json_encode($infosUser); ?>;

    // Extraire les labels (noms) et les données (counts) pour le graphique
    var labels = data.map(function(item) {
        return item.name;
    });

    var counts = data.map(function(item) {
        return item.count;
    });

    //Configuration du graphique en secteurs
    var ctx = document.getElementById('userPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        }
    })
</script>