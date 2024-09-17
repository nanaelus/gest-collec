<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Types d'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="admin/item/createtype" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un type</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du type</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Type du parent</label>
                    <select class="form-select" name="id_type_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_types as $type) { ?>
                        <option value="<?= $type['id'] ; ?>"><?= $type['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Liste des types</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableTypes">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Id Parent</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Modif.</th>
                        <th>Supp.</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

<!-- modal-->

<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var dataTable = $('#tableTypes').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax": {
                "url" : "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type": "POST",
                "data" : {'model' : "ItemTypeModel"}
            },
            "columns" : [
                {"data": 'id'},
                {"data" : "id_type_parent"},
                {"data" : "name"},
                {"data" : "slug"},
                {
                    data: 'id',
                    sortable: false,
                    render: function (data) {
                        return `<button type="button" class="fa-solid fa-pencil" data-bs-toggle="modal" data-bs-target="update-btn" ></button>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-type" id="${data}" swal2-title="Êtes vous sûr de vouloir supprimer ce type ?" swal2-text="" href="/admin/item/deletetype/${data}"><i class="fa-solid fa-trash"></i></a>`;
                    }
                },
            ]
        });
        $("body").on("click", '.swal2-type', function (event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-title");
            let link = $(this).attr("href");
            let id = $(this).attr("id");
            if (id==1) {
                Swal.fire("TU NE PEUX PAS SUPPRIMER \"Non classé\" !")
            } else {
                $.ajax({
                    type: 'GET',
                    url: "<?= base_url('/admin/item/totalitembytype'); ?>",
                    data: {
                        id : id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data)
                        console.log(json.total);
                        let title = "Supprimer un type"
                        let text = `Ce type est attribué à <b class="text-danger">${json.total}</b> objets. Êtes vous sûr de vouloir continuer?`;
                        warningswal2(title, text, link);
                    }
                })
            }
        });
    })

</script>