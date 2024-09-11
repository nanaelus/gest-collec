<div class="row">
    <div class="col">
        <form action="<?= isset($utilisateur) ? "/admin/user/update" : "/admin/user/create" ?>" method="POST"  enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <?= isset($utilisateur) ? "Editer " . $utilisateur['username'] : "Créer un utilisateur" ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="username" placeholder="username" value="<?= isset($utilisateur) ? $utilisateur['username'] : ""; ?>" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">E-mail</label>
                        <input type="text" class="form-control" id="mail" placeholder="mail" value="<?= isset($utilisateur) ? $utilisateur['email'] : "" ?>" name="email" <?= isset($utilisateur) ? "readonly" : "" ?> >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" placeholder="password" value="" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="id_permission" class="form-label">Rôle</label>
                        <select class="form-select" id="id_permission" name="id_permission">
                            <option disabled <?= !isset($utilisateur) ? "selected":""; ?> >Selectionner un role</option>
                            <?php foreach($permissions as $p): ?>
                                <option value="<?= $p['id']; ?>" <?= ( isset($utilisateur) && $p['id'] == $utilisateur['id_permission']) ? "selected" : "" ?> >
                                    <?= $p['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Avatar</label>
                        <input class="form-control" type="file" name="profile_image" id="image" />
                    </div>
                </div>
                <div class="card-footer text-end">
                    <?php if (isset($utilisateur)): ?>
                        <input type="hidden" name="id" value="<?= $utilisateur['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($utilisateur) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>