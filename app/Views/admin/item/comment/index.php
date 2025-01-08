<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des commentaires</h4>
        <a href="<?= base_url('/admin/item/new'); ?>"><i class="fa-solid fa-circle-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover" id="tableComments">
            <thead>
            <tr>
                <th>ID du commentaire</th>
                <th>Nom d'utilisateur</th>
                <th>ID de l'objet</th>
                <th>Nom de l'objet</th>
                <th>Commentaire</th>
                <th>Modifier</th>
                <th>Actif</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableComments').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            },
            "ajax": {
                "url": "<?= base_url('/admin/item/searchdatatable'); ?>",
                "type": "POST",
                "data" : { 'model' : 'CommentModel'},
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "id_item"},
                {"data" : 'item_name'},
                {"data" : 'content'},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a id="${data}" href="<?= base_url('/admin/comment/'); ?>${data}"><i class="fa-solid fa-pencil text-success"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver le commentaire" href="<?= base_url('admin/comment/desactivate/'); ?>${row.id}"><i class="fa-solid fa-xl fa-toggle-off text-success"></i></a>`: `<a title="Activer  un commentaire" href="${baseUrl}admin/comment/activate/${row.id}"><i class="fa-solid fa-toggle-on fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });
</script>