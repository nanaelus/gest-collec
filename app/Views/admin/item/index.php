<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Objets</h4>
        <a href="/admin/item/new"><i class="fa-solid fa-circle-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover" id="tableItems">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Voir</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url() ;?>";
        var dataTable = $('#tableItems').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            language: {
                url: '<?= base_url("/js/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax": {
                "url": "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type": "POST",
                "data" : { 'model' : 'ItemModel'},
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.active == 1 ?
                            `<a title="Désactiver" href="/admin/item/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>`: `<a title="Activer"href="/admin/item/activate/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                },
                {
                    data : 'slug',
                    sortable : false,
                    render : function(data) {
                        return `<a target ="_blank" href="/item/${data}"><i class="fa-solid fa-eye"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="/admin/item/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="/admin/item/deleteitem/${data}"><i class="fa-solid fa-trash text-danger"></i></a>`;
                    }
                },
            ]
        });
    });
</script>