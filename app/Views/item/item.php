
<div class="row">
    <div class="col">
        <?php if (isset($item) && $item != null): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1><?= $item['item_name']; ?></h1>
                    <a href="<?= base_url('item?type[slug]=' . $item['type_slug']); ?>" class="badge rounded-pill text-bg-info link-underline-opacity-0"><?= $item['type_name']; ?></a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- START: Main Image Carousel -->
                                        <div class="col">
                                            <section id="main-carousel" class="splide" aria-label="Images de l'objet">
                                                <div class="splide__track">
                                                    <ul class="splide__list">
                                                        <?php foreach($item['medias'] as $images) : ?>
                                                            <li class="splide__slide">
                                                                <img src="<?= base_url($images['file_path']); ?>" alt="">
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </section>
                                            <!-- START: Thumbnail Carousel with Icons -->
                                            <section id="thumbnail-carousel" class="splide border p-4 mt-3" aria-label="Thumbnail carousel">
                                                <div class="splide__track">
                                                    <ul class="splide__list">
                                                        <?php foreach($item['medias'] as $images) : ?>
                                                            <li class="splide__slide rounded">
                                                                <img src="<?= base_url($images['file_path']); ?>" alt="">
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </section>
                                        </div>
                                        <!-- END: Main Image Carousel -->
                                    </div>
                                    <div class="row">
                                        <!--START: DESCRIPTION -->
                                        <div class="col p-3">
                                            <h3>Description de l'objet</h3>
                                            <div class="text">
                                                <?= $item['description']; ?>
                                            </div>
                                        </div>
                                        <!--END: DESCRIPTION -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col">
                                    <div class="card p-3">
                                        <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-success"><i class="fa-solid fa-plus fa-lg"></i> Ajouter à ma collection</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="card p-3">
                                        <p>Date de sortie :
                                            <?php if ($item['release_date'] != '0000-00-00') {
                                                echo $item['release_date'];
                                            } else {
                                                echo "-";
                                            } ?>
                                        </p>
                                        Prix : <?= $item['price']; ?>€
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="card p-3">
                                        <p>
                                            Licence : <a href="<?= base_url('item?license[slug]=' . $item['license_slug']); ?>" class="badge rounded-pill text-bg-info"><?= $item['license_name']; ?></a>
                                        </p>
                                        <hr>
                                        <p>
                                            Marque : <a href="<?= base_url('item?brand[slug]=' . $item['brand_slug']); ?>" class="badge rounded-pill text-bg-info"><?= $item['brand_name']; ?></a>
                                        </p>
                                        <hr>
                                        <p>
                                            Genres :
                                        </p>
                                        <?php foreach($item['genres'] as $genre) { ?>
                                            <a href="#" class="badge rounded-pill text-bg-info"><?= $genre['name']; ?></a>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                L'objet que vous souhaitez consulter n'existe pas où n'est pas accessible.
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- START: OFFCANVAS -->
<?php if (isset($user) && $user->isAdmin()) : ?>
    <a class="link-underline-opacity-0 position-fixed bottom-0 end-0 m-4" data-bs-toggle="offcanvas" href="#offcanvasItem" role="button" aria-controls="offcanvasExample">
        <i class="fa-solid fa-circle-question fa-2xl"></i>
    </a>

    <div class="offcanvas offcanvas-end" style="width:800px" data-bs-backdrop="static" tabindex="-1" id="offcanvasItem" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Mon Objet</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <pre>
                  <?php
                  if (isset($item)) {
                      print_r($item);
                  }?>
                </pre>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- END: OFFCANVAS -->
<style>
    /* Style du carousel principal */
    #main-carousel {
        width: 100%;
        height: 400px;
        position: relative;
        overflow: hidden;
    }

    .splide__slide {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .splide__slide img {
        max-width: 100%;  /* L'image ne doit jamais dépasser la largeur du container */
        max-height: 100%; /* L'image ne doit jamais dépasser la hauteur du container */
        object-fit: contain; /* Conserve le ratio de l'image sans la déformer */
        object-position: center; /* Centre l'image dans le container */
    }


    /* Style du carousel de thumbnails */
    #thumbnail-carousel {
        width: 100%;
    }

    #thumbnail-carousel .splide__slide {
        width: 80px; /* Taille fixe des thumbnails */
        height: 80px; /* Taille fixe des thumbnails */
        display: flex;
        justify-content: center;
        align-items: center;

        opacity:0.6;
    }

    #thumbnail-carousel img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    #thumbnail-carousel .is-active {
        opacity: 1;
    }

    /* Flèches pour naviguer entre les thumbnails */
    .splide__arrow {
        background-color: rgba(0, 0, 0, 0.5); /* Arrière-plan semi-transparent pour les flèches */
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .splide__arrow--prev {
        left: 0px; /* Positionne la flèche à gauche du thumbnail carousel */
    }

    .splide__arrow--next {
        right: 0px; /* Positionne la flèche à droite du thumbnail carousel */
    }

</style>
<script>
    $(document).ready(function(){
        $(document).ready(function() {
            // Initialisation du carousel principal
            var mainCarousel = new Splide('#main-carousel', {
                type      : 'fade',  // Utilise un effet de fondu pour la transition entre les slides
                height    : '400px',
                width     : '100%',  // Assure que le carousel utilise toute la largeur disponible
                pagination: false,    // Active la pagination si souhaité
                arrows    : false,    // Garde les flèches
                cover     : false,   // Pour éviter des comportements non désirés avec cover
                rewind    : true,    // Revient au début à la fin
                perPage   : 1,       // Affiche une image par page
                breakpoints: {       // Permet d'ajuster le comportement selon la taille de l'écran
                    768: {
                        height: '300px',  // Ajuste la hauteur pour les écrans plus petits
                    },
                },
            }).mount();

            // Initialisation du carousel de thumbnails
            var thumbnailCarousel = new Splide('#thumbnail-carousel', {
                fixedWidth  : 80,    // Largeur fixe des thumbnails
                fixedHeight : 80,    // Hauteur fixe des thumbnails
                isNavigation: true,  // Permet la navigation via ce carousel
                gap         : 10,    // Espace entre les thumbnails
                focus       : 'center',
                pagination  : true,
                cover       : true,
                arrows      : true,  // Ajout des flèches de navigation
                rewind      : true,
                breakpoints : {
                    600: {
                        fixedWidth : 60,
                        fixedHeight: 60,
                    },
                },
            }).mount();

            // Synchronisation des deux carousels
            mainCarousel.sync(thumbnailCarousel);
        });

    })
</script>