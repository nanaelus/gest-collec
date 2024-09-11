<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Licence de l'objet</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="admin/item/createlicense" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter une Licence</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom de la Licence</label>
                    <input type="text" class="form-control" name="name">
                    <label class="form-label">Type du parent</label>
                    <select class="form-select" name="id_license_parent">
                        <option value="" selected>Aucun</option>
                        <?php foreach ($all_licenses as $license) { ?>
                            <option value="<?= $license['id'] ; ?>"><?= $license['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Gestion des Licences</h4>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover" id="tableLicenses">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Parent</th>
                        <th>Nom de la Licence</th>
                        <th>Slug</th>
                        <th>Modif.</th>
                        <th>Sup.</th>
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

<script>
    $(document).ready(function () {
        var dataTable = $('#tableLicenses').DataTable({
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
                "data" : {'model' : 'ItemLicenseModel'}
            },
            "columns" : [
                {"data": 'id'},
                {"data" : "id_license_parent"},
                {"data" : "name"},
                {"data" : "slug"},
                {"data" : "slug"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a class="swal2-license" id="${data}" swal2-title="Êtes tous sûr de vouloir supprimer cette licence?" swal2-text="" href="/admin/item/deletelicense/${data}"><i class="fa-solid fa-trash"></i></a>`;
                    }
                },
            ]
        });
        $("body").on("click", '.swal2-license', function (event) {
            event.preventDefault();
            let title = $(this).attr("swal2-title");
            let text = $(this).attr("swal2-title");
            let link = $(this).attr("href");
            let id = $(this).attr("id");
            if (id==1) {
                Swal.fire("TU NE PEUX PAS SUPPRIMER \"Aucune Marque\" !")
            } else {
                $.ajax({
                    type: 'GET',
                    url: "<?= base_url('/admin/item/totalitembylicense'); ?>",
                    data: {
                        id : id,
                    },
                    success: function (data) {
                        let json = JSON.parse(data)
                        console.log(json.total);
                        let title = "Supprimer une marque"
                        let text = `Cette marque est attribuée à <b class="text-danger">${json.total}</b> objets. Êtes vous sûr de vouloir continuer?`;
                        warningswal2(title, text, link);
                    }
                })
            }
        });
    })
</script>