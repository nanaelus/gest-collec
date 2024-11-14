<?php
// Récupère le service du routeur de CodeIgniter
$router = service('router');
// Récupère le nom du contrôleur actuel en minuscule pour l'utiliser dans les liens
$controller = strtolower(basename(str_replace('\\', '/', $router->controllerName())));
?>
<div class="row">
    <!-- Section des filtres pour affiner les résultats -->
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">Filtre de recherche</div>
            <div class="card-body">
                <!-- Formulaire permettant de filtrer les résultats via la méthode GET -->
                <form method="get" action="<?= base_url($controller); ?>">
                    <!--Filtrer les objets par les noms-->
                    <label class="form-label" for="itemName">Rechercher par nom d'objet</label>
                    <input type="text" class="form-control mb-2" id="itemName" name="itemName[slug]">
                    <!-- Filtre pour les licences -->
                    <label class="form-label" for="license">Licenses</label>
                    <select class="form-select mb-3" name="license[slug]" id="license">
                        <option selected disabled value="">Aucun</option>
                        <!-- Boucle à travers toutes les licences pour les afficher en options -->
                        <?php foreach($licenses as $license): ?>
                            <option value="<?= $license['slug']; ?>" <?= (isset($data['license']) && $data['license']['slug'] == $license['slug']) ? "selected" : ""; ?>><?= $license['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Filtre pour les marques -->
                    <label class="form-label" for="brand">Marques</label>
                    <select class="form-select mb-3" name="brand[slug]" id="brand">
                        <option selected disabled value="">Aucun</option>
                        <!-- Boucle à travers toutes les marques pour les afficher en options -->
                        <?php foreach($brands as $brand): ?>
                            <option value="<?= $brand['slug']; ?>" <?= (isset($data['brand']) && $data['brand']['slug'] == $brand['slug']) ? "selected" : ""; ?>><?= $brand['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Filtre pour les types d'objets -->
                    <label class="form-label" for="type">Types</label>
                    <select class="form-select mb-3" name="type[slug]" id="type">
                        <option selected disabled value="">Aucun</option>
                        <!-- Boucle à travers tous les types pour les afficher en options -->
                        <?php foreach($types as $type): ?>
                            <option value="<?= $type['slug']; ?>" <?= (isset($data['type']) && $data['type']['slug'] == $type['slug']) ? "selected" : ""; ?>><?= $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Si la page est définie dans les données GET, ajoute un champ caché pour la pagination -->
                    <?php if (isset($data['page'])) { ?>
                        <input type="hidden" value="<?= $data['page']; ?>" name="page">
                    <?php }?>
                    <?php if (isset($data['search'])) { ?>
                        <input type="hidden" value="<?= $data['search']; ?>" name="search">
                    <?php }?>
                    <!-- Bouton de validation des filtres -->
                    <div class="d-grid">
                        <button class="btn btn-primary mt-3" type="submit">Valider mes filtres</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Section principale pour afficher la liste des objets -->
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header">Liste des objets
                <?php
                // Si le contrôleur est "collection", afficher que les objets appartiennent à la collection de l'utilisateur
                if ($controller == "collection") {
                    echo "de la collection de " . ucfirst($data['username']);
                    if ($user->username != $data['username']) { ?>
                        <a href="<?= base_url("/user/sendmessage/" . $data['username']); ?>" title="Envoyer un message privé">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                        <?php
                    }
                }
                // Vérification et affichage des filtres appliqués
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
                <!-- Boucle pour diviser les items en groupes de 4, afin d'organiser l'affichage par lignes -->
                <?php foreach(array_chunk($items, 4) as $chunk) : // Diviser les éléments en groupes de 4 ?>
                    <div class="row shelf-row px-4 ">
                        <!-- Boucle à travers chaque item du groupe de 4 -->
                        <?php foreach($chunk as $item) : ?>
                            <div class="col-md-3 col-6">
                                <?php
                                // Initialiser une variable pour vérifier si l'item est déjà dans la collection de l'utilisateur
                                $alreadyInCollection = false;
                                // Vérifier si la variable collectionUser est définie et si l'item y est présent
                                if (isset($collectionUser)) {
                                    foreach ($collectionUser as $CU) {
                                        if ($CU['id_item'] == $item['id']) {
                                            $alreadyInCollection = true;
                                            break; // Sortir de la boucle dès que l'item est trouvé dans la collection
                                        }
                                    }
                                }
                                // Si l'item est déjà dans la collection, afficher un badge d'indication
                                if ($alreadyInCollection) { ?>
                                    <span class="position-absolute top-5 start-5 translate-middle p-2 bg-primary border border-light rounded-circle"></span>
                                <?php } ?>
                                <!--AFFICHAGE DE LA CARTE D'UN ITEM-->
                                <div class="card h-100">
                                    <!--AFFICHAGE DE L'IMAGE PRINCIPALE-->
                                    <?php
                                    // Utilise l'image par défaut si aucune image n'est disponible pour l'item
                                    $img_src = !empty($item['default_img_file_path']) ? base_url($item['default_img_file_path']) : base_url('assets/brand/logo-bleu.svg');
                                    ?>
                                    <a href="<?= base_url('item/' . $item['slug']) ?>">
                                        <img src="<?= $img_src ?>" class="card-img-top" alt="<?= $item['name']; ?>">
                                    </a>
                                    <!--AFFICHAGE DU NOM DE L'OBJET-->
                                    <div class="card-body">
                                        <div class="card-title"><?= ucfirst($item['name']); ?></div>
                                    </div>
                                    <!--AFFICHAGE DES OPTIONS POUR AJOUTER OU SUPPRIMER DANS LA COLLECTION L'OBJET-->
                                    <div class="card-footer text-center">
                                        <!--DANS LE CAS DE LA PAGE COLLECTION-->
                                        <?php if ($controller == "collection") { ?>
                                            <!-- Si l'on est sur la page de collection, possibilité de retirer l'item -->
                                            <a href="<?= base_url("/collection/removecollection/" . $item['id']) ?>" class="btn btn-danger btn-sm" title="Supprimer de ma collection">
                                                <i class="fa-solid fa-minus fa-lg"></i> Supprimer
                                            </a>
                                            <!--DANS LE CAS DE LA PAGE ITEM-->
                                        <?php } else {
                                            $alreadyInCollection = false;
                                            if (isset($collectionUser)) {
                                                foreach ($collectionUser as $CU) {
                                                    if ($CU['id_item'] == $item['id']) {
                                                        $alreadyInCollection = true;
                                                        break; // Sortir de la boucle dès que l'item est trouvé dans la collection
                                                    }
                                                }
                                            }
                                            // Si l'item est dans la collection, afficher le bouton supprimer-->
                                            if ($alreadyInCollection) { ?>
                                                <a href="<?= base_url("/collection/removecollection/" . $item['id']) ?>" class="btn btn-danger btn-sm" title="Supprimer de ma collection">
                                                    <i class="fa-solid fa-minus fa-lg"></i> Supprimer
                                                </a>
                                            <?php } else { ?>
                                                <!-- Si l'item n'est pas dans la collection, afficher le bouton Ajouter -->
                                                <a href="<?= base_url("/collection/addcollection/" . $item['id']) ?>" class="btn btn-success btn-sm" title="Ajouter à ma collection">
                                                    <i class="fa-solid fa-plus fa-lg"></i> Ajouter
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <!-- Affichage de la pagination au bas de la page -->
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
<!-- Styles personnalisés pour l'apparence des étagères (shelf) -->
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
    /* Ajustement des étagères pour les petits écrans */
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
    });
    $('#license').select2({
        theme: 'bootstrap-5',
        placeholder: 'recherche une licence',
        allowClear: true,
    });
    $('#brand').select2({
        theme: 'bootstrap-5',
        placeholder: 'recherche une marque',
        allowClear: true,

    });
    $('#type').select2({
        theme: 'bootstrap-5',
        placeholder: 'recherche un type',
        allowClear: true,

    });
</script>






<!-- START: OFFCANVAS -->
<?php if (isset($user) && $user->isAdmin()) : ?>
    <a class="link-underline-opacity-0 position-fixed bottom-0 end-0 m-4" data-bs-toggle="offcanvas" href="<?=base_url('#offcanvasItem')?>" role="button" aria-controls="offcanvasExample">
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
                  if (isset($collectionUser)) {
                      echo "collectionUser<br>";
                      print_r($collectionUser);
                  }?>
                </pre>
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