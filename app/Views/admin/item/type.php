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
        <form action="" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5>Ajouter un type</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Nom du type</label>
                    <input type="text" class="form-control" name="name">
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
                        <th>Nom</th>
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
<script>
    $(document).ready(function () {
        var dataTable = $('#tableTypes').DataTable({
            "responsive": true,
            "pageLength": 10,
            "language": {
                url: '<?= base_url("/js/datatable/datatable-2.1.4-fr-FR.json") ?>',
            }
        });
    })
</script>