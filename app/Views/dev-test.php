<script>
    $(document).ready(function(){
        function(data){
            data = JSON.parse(data);
            data.forEach(function(narouille) {
                const narouilleElement = `<div class="modal fade update-btn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-id="${narouille.id}>
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/item/updatetype" method="POST">
                <div class="modal-header">
                    Modification du Type
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nom du type</label>
                    <input type="text" class="form-control narouille" name="name" value="${narouille.type_name}">
                    <label class="form-label">Type du parent</label>
                    <select class="form-select" name="id_type_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_types as $type) { ?>
                            <option value="<?= $type['id'] ; ?>"><?= $type['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>`
            });
        }
    })
</script>
