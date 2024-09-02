<?php print_r($role) ;?>
<div class="container">
    <div class="row">
        <div class="col">
            <form action="<?= isset($permissions) ? "/admin/userpermission/update" : "/admin/userpermission/create" ; ?> "method="POST">
                <div class="card">
                    <div class="mb-3">
                    <label class="form-label" >Nom du rôle</label>
                    <input type="text" name="name" class="form-control" id="role" value="<?= isset($permissions) ? $role['name'] : ""; ?>">
                    </div>
                    <div class="col d-flex justify-content-center">
                    <input type="hidden" name="id" id="id" value="<?= $role['id']; ?>">
                    <button class="btn btn-primary" type="submit"><?=isset($permissions) ? "Modifier" : "Créer" ; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>