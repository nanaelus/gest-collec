<div class="row">
    <div class="col">
        <form action="<?= isset($user) ? base_url('/admin/user/update') : base_url("/admin/user/create") ?>" method="POST"  enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <?= isset($user) ? "Editer " . $user->username : "Créer un utilisateur" ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="username" placeholder="username" value="<?= isset($user) ? $user->username : ""; ?>" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">E-mail</label>
                        <input type="text" class="form-control" id="mail" placeholder="mail" value="<?= isset($user) ? $user->email : "" ?>" name="email" <?= isset($user) ? "readonly" : "" ?> >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" placeholder="password" value="" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Avatar</label>
                        <input class="form-control" type="file" name="profile_image" id="image" />
                    </div>
                </div>
                <div class="card-footer text-end">
                    <?php if (isset($user)): ?>
                        <input type="hidden" name="id" value="<?= $user->id; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($user) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>