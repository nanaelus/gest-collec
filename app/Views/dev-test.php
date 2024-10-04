<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header"><h3>Ma Collection</h3></div>
            <div class="card-body">
                <table class="table-hover table-sm table-striped table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Marque</th>
                        <th>Licence</th>
                        <th>Voir</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                    <tbody>
                    <?php foreach ($possede as$p) { ?>
                     <tr>
                         <td><?= $p['name']; ?></td>
                         <td><?= $p['brand']; ?></td>
                         <td><?= $p['license']; ?></td>
                         <td>
                             <a href="<?= base_url('/item/' . $item['slug']) ;?>"><i class="fa-solid fa-eye"></i></a>
                         </td>
                         <td>
                             <a href="<?= base_url('/collection/removecollection/' . $item['id']);?>"><i class="fa-solid fa-trash"></i></a>
                         </td>
                         <td><?= $p['']; ?></td>
                     </tr>
                    <?php } ?>
                    </tbody>
            </div>
        </div>
    </div>
</div>