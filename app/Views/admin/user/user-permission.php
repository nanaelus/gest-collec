<div class="container">
    <div class="row">
        <div class="col">
            <form action="<?= isset($permission) ? base_url("/admin/userpermission/update") : base_url("/admin/userpermission/create"); ?>" method="POST">
                <div class="card">
                    <div class="mb-3">
                    <label class="form-label" >Nom du rôle</label>
                    <input type="text" name="name" class="form-control" id="role" value="<?= isset($permission) ? $permission['name'] : ""; ?>">
                    </div>
                    <div class="col d-flex justify-content-center">
                    <input type="hidden" name="id" id="id" value="<?= isset($permission) ? $permission['id'] : ""; ?>">
                    <button class="btn btn-primary" type="submit"><?= isset($permission) ? "Modifier" : "Créer" ; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>