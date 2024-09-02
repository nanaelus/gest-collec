<div class="row">
    <div class="col">
        <form action="<?= isset($utilisateur) ? "/admin/user/update" : "/admin/user/create" ; ?> "method="POST">
            <div class="card">
                <div class="card-header">
                    <h4><?= isset($utilisateur) ? "Modifer l'utilisateur :" . $utilisateur['username'] : "Création d'un utilisateur"; ?></h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= isset($utilisateur) ? $utilisateur['username']: "" ; ?>" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($utilisateur)? $utilisateur['email'] : ""; ?>" placeholder="Adresse email" <?= isset($utilisateur) ? "readonly" : "" ; ?>>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                    </div>
                    <div class="mb-3">
                        <label for="id_permission" class="form-label">Rôle</label>
                            <select class="form-select" id="id_permission" name="id_permission">
                                <option selected disabled>Type de permission</option>
                                <?php foreach ($permissions as $p){ ?>
                                <option value="<?= $p['id']; ?>" <?= (isset($utilisateur) && $p['id'] == $utilisateur['id_permission'])  ? 'selected' : ""; ?> ><?= $p['name']; ?> </option>
                                <?php } ?>
                            </select>
                    </div>
                </div>
                <div class="card-footer">

                </div>
                <?php if(isset($utilisateur)) { ?>
                <input type="hidden" name="id" value="<?= isset($utilisateur) ? $utilisateur['id'] : ""; ?>">
                <?php } ?>
                <button type="submit" class="btn btn-primary"><?= isset($utilisateur) ? "Modifier" : "Créer" ;?></button>
            </div>
        </form>
    </div>
</div>