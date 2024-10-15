<?php
$router = service('router');
$controller = strtolower(basename(str_replace('\\', '/', $router->controllerName())));
?>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">Filtre de recherche</div>
            <div class="card-body">
                <form method="get" action="<?= base_url($controller); ?>">
                    <label class="form-label mt-3" for="license">Licenses</label>
                    <select class="form-select" name="license[slug]" id="license">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($licenses as $license): ?>
                            <option value="<?= $license['slug']; ?>" <?= (isset($data['license']) && $data['license']['slug'] == $license['slug']) ? "selected" : ""; ?>><?= $license['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label mt-3" for="brand">Marques</label>
                    <select class="form-select" name="brand[slug]" id="brand">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($brands as $brand): ?>
                            <option value="<?= $brand['slug']; ?>" <?= (isset($data['brand']) && $data['brand']['slug'] == $brand['slug']) ? "selected" : ""; ?>><?= $brand['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label mt-3" for="type">Types</label>
                    <select class="form-select" name="type[slug]" id="type">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($types as $type): ?>
                            <option value="<?= $type['slug']; ?>" <?= (isset($data['type']) && $data['type']['slug'] == $type['slug']) ? "selected" : ""; ?>><?= $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($data['page'])) { ?>
                        <input type="hidden" value="<?= $data['page']; ?>" name="page">
                    <?php }?>
                    <?php if (isset($data['search'])) { ?>
                        <input type="hidden" value="<?= $data['search']; ?>" name="search">
                    <?php }?>
                    <div class="d-grid">
                        <button class="btn btn-primary mt-3" type="submit">Valider mes filtres</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header">Liste des objets
                <?php
                if ($controller == "collection") {
                    echo "de la collection de " . $data['username'];
                }
                if ($data) {
                    $filtre_text = "| Filtrer par :  ";
                    foreach ($data as $filter => $slug) {
                        switch ($filter) {
                            case 'license' :
                                $filtre_text .= "<a data-bs-toggle='tooltip' 
                                                title='Filtrer par la licence' href='" . base_url('item?license[slug]=') . $slug['slug'] . "'>".$slug['slug'] ."</a> ";
                                break;
                            case 'brand' :
                                $filtre_text .= "<a data-bs-toggle='tooltip' 
                                                title='Filtrer par la marque' href='" . base_url('item?brand[slug]=') . $slug['slug'] . "'>".$slug['slug'] ."</a> ";
                                break;
                            case 'type' :
                                $filtre_text .= "<a data-bs-toggle='tooltip' 
                                                title='Filtrer par le type' href='" . base_url('item?type[slug]=') . $slug['slug'] . "'>".$slug['slug'] ."</a> ";
                                break;
                            case 'search' :
                                $filtre_text .= "<a data-bs-toggle='tooltip' 
                                                title='Contient le terme' href='" . base_url('item?search=') . $slug . "'>".$slug ."</a> ";
                        }
                    }
                    echo $filtre_text;
                }
                ?>
            </div>
            <div class="card-body">
                <?php foreach(array_chunk($items, 4) as $chunk) : // Diviser les éléments en groupes de 4 ?>
                    <div class="row shelf-row px-4 ">
                        <?php foreach($chunk as $item) : ?>
                            <div class="col-md-3 col-6">
                                <div class="card h-100">
                                    <?php
                                    $img_src = !empty($item['default_img_file_path']) ? base_url($item['default_img_file_path']) : base_url('assets/img/full.jpg');
                                    ?>
                                    <a href="<?= base_url('item/' . $item['slug']) ?>">
                                        <img src="<?= $img_src; ?>" class="card-img-top" alt="...">
                                    </a>
                                    <div class="card-body">
                                        <div class="card-title"><?= $item['name']; ?></div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="<?= base_url("/collection/removecollection/" . $item['id']) ?>" class="btn
                                            btn-danger btn-sm" title="Retirer de ma collection"><i class="fa-solid
                                            fa-minus
                                            fa-lg"></i> Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col">
                        <div class="pagination justify-content-center">
                            <?= $pager->links('default', 'bootstrap_pagination'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .shelf-row {
        position: relative; /* Positionnement nécessaire pour le pseudo-élément */
        margin-bottom: 50px; /* Assurez-vous d'avoir un espace en bas pour l'étagère */
    }

    .shelf-row::after {
        content: '';
        display: block; /* Rendre le pseudo-élément un bloc pour pouvoir ajuster la largeur */
        background-image: url("https://www4-static.gog-statics.com/bundles/gogwebsiteaccount/img/shelf/wood.png"); /* Lien vers l'image de l'étagère */
        background-size: cover; /* S'assurer que l'image couvre toute la largeur */
        background-repeat: no-repeat; /* Éviter que l'image se répète */
        position: absolute; /* Positionnement absolu par rapport au conteneur */
        bottom: -57px; /* Positionner l'étagère en bas du conteneur */
        left: 0; /* Aligné à gauche */
        width: 100%; /* Largeur de l'étagère à 100% */
        height: 85px; /* Ajuster la hauteur de l'étagère selon vos besoins */
        z-index: 0; /* Mettre l'étagère derrière les cartes */
    }
    @media(max-width: 768px) {
        .shelf-row::after {
            content: none;
        }
        .shelf-row {
            margin-bottom: 0;
        }
        .shelf-row .col-6 {
            margin-bottom: 1em;
        }
    }
    .shelf-row .col-md-3 {
        z-index: 1;
    }
    .shelf-row .card {
        box-shadow: 0 1px 5px rgba(0,0,0,.15);
        overflow: hidden;
    }

    .shelf-row .card-footer {
        position: absolute; /* Nécessaire pour l'effet */
        bottom: -50px; /* Ajustez cette valeur pour que le footer soit hors de la carte initialement */
        left: 0;
        right: 0;
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.3s ease; /* Effet de transition pour la visibilité */
    }


</style>
<script>
    $(document).ready(function() {
        $('.shelf-row .card').on('mouseenter', function() {
            // Lorsque la souris entre dans la carte
            $(this).find('.card-footer').stop().animate({
                bottom: '0',   // Faites remonter le footer
                opacity: '1'   // Rendre le footer visible
            }, 300); // Durée de l'animation
        }).on('mouseleave', function() {
            // Lorsque la souris quitte la carte
            $(this).find('.card-footer').stop().animate({
                bottom: '-50px', // Faites descendre le footer pour qu'il disparaisse
                opacity: '0'     // Rendre le footer invisible
            }, 300);
        });
        $("#license").select2({
            theme : 'bootstrap-5',
            placeholder : 'Rechercher une licence'
        });
        $("#brand").select2({
            theme : 'bootstrap-5',
            placeholder : 'Rechercher une marque'
        });
        $("#type").select2({
            theme : 'bootstrap-5',
            placeholder : 'Rechercher un type'
        });
    });
</script>
<!-- START: OFFCANVAS -->
<?php if (isset($user) && $user->isAdmin()) : ?>
    <a class="link-underline-opacity-0 position-fixed bottom-0 end-0 m-4" data-bs-toggle="offcanvas" href="#offcanvasItem" role="button" aria-controls="offcanvasExample">
        <i class="fa-solid fa-circle-question fa-2xl"></i>
    </a>

    <div class="offcanvas offcanvas-end" style="width:800px" data-bs-backdrop="static" tabindex="-1" id="offcanvasItem" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Mes Objets</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>

                <pre>
                  <?php
                  if (isset($data)) {
                      echo "DATA<br>";
                      print_r($data);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($items)) {
                      echo "ITEMS<br>";
                      print_r($items);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($brands)) {
                      echo "BRANDS<br>";
                      print_r($brands);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($licenses)) {
                      echo "LICENSES<br>";
                      print_r($licenses);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($types)) {
                      echo "TYPES<br>";
                      print_r($types);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($genres)) {
                      echo "GENRES<br>";
                      print_r($genres);
                  }?>
                </pre>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- END: OFFCANVAS -->