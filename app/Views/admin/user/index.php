<div class="container">
    <div class="row">
        <div class="col">
            <div class="table table-sm table-hover">
            <div class="card">
                <div class="card-header">
                    <h3>Liste des utilisateurs</h3>
                </div>
                <div class="card-body">
                    <div class="card">
                        <table id="tableUsers" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Mail</th>
                                <th>Rôle</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                var dataTable = $('#tableUsers').DataTable({
                                    "responsive": true,
                                    "processing": true,
                                    "serverSide": true,
                                    "pageLength": 50,
                                    language: {
                                        url: '<?= base_url("/js/datatable-2.1.4-fr-FR.json") ?>',
                                    },
                                    "ajax": {
                                        "url": "<?= base_url('/admin/user/SearchUser'); ?>",
                                        "type": "POST"
                                    },
                                    "columns": [
                                        {"data": "id"},
                                        {"data": "username"},
                                        {"data": "email"},
                                        {"data": "permission_name"},
                                        {
                                            data: "id",
                                            sortable : false,
                                            render: function (data, type, row) {
                                                return `<a href="/admin/user/${row.id}"><i class="fa-solid fa-pencil"></i></a>`
                                            }
                                        }
                                    ]
                                });
                            });
                        </script>
                    </tbody>
                </div>
                <div class="card-footer">
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
