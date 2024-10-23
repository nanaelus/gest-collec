<div class="row">
    <div class="col">
        <form method="POST" action="<?= base_url('/admin/comment/updatecomment'); ?>">
            <div class="card">
                <div class="card-header">
                    <h3>Editer le commentaire n°<?= $comment['id']; ?></h3>
                </div>
                <div class="card-body">
                    <div>
                        Publié par : <a href="<?= base_url('/admin/user/' . $comment['id_user']); ?>"><?= $comment['username']; ?></a>
                    </div>
                    <div>
                        Le : <?= $comment['updated_at']; ?>
                    </div>
                    <div>
                        Sur l'objet : "<a href="<?= base_url('/admin/item/' . $comment['entity_id']); ?>"><?= $comment['name']; ?></a>" (id item n°: <?= $comment['entity_id']; ?>)
                    </div>
                    <label> Contenu du commentaire : </label>
                    <textarea type="text" class="form-control" name="content" ><?= $comment['content']; ?></textarea>
                    <input type="hidden" name="id" value="<?= $comment['id']; ?>">
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Modifer</button>
                </div>
            </div>
        </form>
    </div>
</div>