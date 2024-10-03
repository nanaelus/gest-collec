<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-body"><h4>Gestion des medias</h4></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">
                <h5>Filtres</h5>
            </div>
            <div class="card-body">
                <label for="filter-type" class="form-label">Filtrer par type</label>
                <select id="filter-type" class="form-select" name="filter-type">
                    <option selected value="none">Aucun filtre</option>
                    <option value="user">Utilisateur</option>
                    <option value="item">Objet</option>
                    <option value="brand">Marque</option>
                    <option value="license">Licence</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header">
                <h5>Medias</h5>
            </div>
            <div class="card-body">
                <div class="row medias">
                    <?php foreach ($medias as $media): ?>
                        <div class="col-4 col-md-2 mb-4 d-flex align-items-center position-relative media" data-id="<?= $media['id']; ?>">
                            <div class="media-mask bg-black bg-opacity-75 d-none rounded">
                                <div class="d-flex flex-column justify-content-center h-100 text-center p-2">
                                    <div class="btn btn-danger mb-3 media-delete">
                                        <i class="fa fa-solid fa-trash"></i> Supprimer
                                    </div>
                                    <div class="btn btn-secondary media-edit">
                                        <i class="fa fa-solid fa-pencil"></i> Editer
                                    </div>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            <?= $media['entity_type'] ?>
                                        </span>
                                </div>
                            </div>
                            <img class="img-thumbnail" src="<?= base_url($media['file_path']) ?>" ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col text-center" id="chargerPlus" data-limit="12" data-offset="12">
                        <div class="btn btn-outline-primary" id="btnChargerPlus">Charger Plus</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.medias').on('mouseenter mouseleave','.media', function(){
            $(this).find('.media-mask').toggleClass('d-none');
        });
        $('.medias').on('click','.media-delete', function(e){
            let media = $(this).closest('.media');
            let id = media.data("id");
            let url = "<?= base_url('/admin/media/delete/') ?>";
            url = url + id;
            Swal.fire({
                title: "Êtes-vous sûr?",
                text: "L'image sera définitivement supprimée !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui !",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function (data) {
                            if (data == "true") {
                                media.remove();
                                Swal.fire({
                                    title: "Supprimé!",
                                    text: "Le fichier à bien été supprimé.",
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "Pas supprimé!",
                                    text: "Le fichier n'a pas été supprimé.",
                                    icon: "error"
                                });
                            }
                        }
                    });
                }
            });
        });
        $('#filter-type').on('change', function(e) {
            let entity_type = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?= base_url('/admin/media/ajaxentitytype'); ?>",
                data: {
                    entity_type : entity_type ,
                },
                success: function (data) {
                    const row = $('.medias'); // Sélectionne la div contenant les médias
                    row.empty(); // Vider le contenu
                    $('#chargerPlus').data('offset', 12);
                    data = JSON.parse(data);
                    // Ajout dynamique des medias
                    data.forEach(function(media) {
                        const mediaElement = `
                            <div class="col-4 col-md-2 mb-4 d-flex align-items-center position-relative media" data-id="${media.id}">
                                <div class="media-mask bg-black bg-opacity-75 d-none rounded">
                                    <div class="d-flex flex-column justify-content-center h-100 text-center p-2">
                                        <div class="btn btn-danger mb-3 media-delete">
                                            <i class="fa fa-solid fa-trash"></i> Supprimer
                                        </div>
                                        <div class="btn btn-secondary media-edit">
                                            <i class="fa fa-solid fa-pencil"></i> Editer
                                        </div>
                                    </div>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            ${media.entity_type}
                                        </span>
                                </div>
                                <img class="img-thumbnail" src="${media.file_path}" alt="media-image">
                            </div>
                        `;
                        row.append(mediaElement);
                    });
                }
            })
        });
        $('#btnChargerPlus').on('click', function(e) {
            let entity_type = $('#filter-type').val();
            let limit = $('#chargerPlus').data('limit');
            let offset = $('#chargerPlus').data('offset');
            $.ajax({
                type: "GET",
                url: "<?= base_url('/admin/media/ajaxloadmore'); ?>",
                data: {
                    entity_type: entity_type,
                    limit: limit,
                    offset: offset,
                },
                success: function (data) {
                    // console.log(data);
                    const row = $('.medias'); // Sélectionne la div contenant les médias
                    data = JSON.parse(data);
                    // Ajout dynamique des medias
                    data.forEach(function(media) {
                        const mediaElement = `
                            <div class="col-4 col-md-2 mb-4 d-flex align-items-center position-relative media" data-id="${media.id}">
                                <div class="media-mask bg-black bg-opacity-75 d-none rounded">
                                    <div class="d-flex flex-column justify-content-center h-100 text-center p-2">
                                        <div class="btn btn-danger mb-3 media-delete">
                                            <i class="fa fa-solid fa-trash"></i> Supprimer
                                        </div>
                                        <div class="btn btn-secondary media-edit">
                                            <i class="fa fa-solid fa-pencil"></i> Editer
                                        </div>
                                    </div>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            ${media.entity_type}
                                        </span>
                                </div>
                                <img class="img-thumbnail" src="${media.file_path}" alt="media-image">
                            </div>
                        `;
                        row.append(mediaElement);
                    });
                    offset = parseInt(offset) + parseInt(limit);
                    $('#chargerPlus').data('offset', offset);
                    console.log($('#chargerPlus').data('offset'));

                }
            });
        });
    });
</script>