<div class="container">
    <div class="row">
        <div class="col">
            <div class="table table-sm table-hover">
                <div class="card">
                    <div class="card-header">
                        <h3>Liste des rôles</h3>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <table id="tableUsers" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID rôle</th>
                                    <th>Nom du rôle</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($permissions as $p) { ?>
                                <tr>
                                    <td><?= $p['id']; ?></td>
                                    <td><?= $p['name']; ?></td>
                                    <td><a href="admin/userpermission/<?= $p['id']; ?>"><i class="fa-solid fa-pencil"></i></a></td>
                                    <td><a href="admin/userpermission/delete/<?= $p['id']; ?>"><i class="fa-solid fa-trash-can"></i></a></td>
                                </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
