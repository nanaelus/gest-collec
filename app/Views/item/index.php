<div class="row">
    <div class="col-md-3">
        <div class="card vh-100">
            <div class="card-header">Mes filtres</div>
            <div class="card-body">
                <form method="get" action="<?= base_url('item'); ?>">
                    <label class="form-label" for="license">Licenses</label>
                    <select class="form-select mb-3" name="license[slug]" id="license">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($licenses as $license): ?>
                            <option value="<?= $license['slug']; ?>"><?= $license['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label" for="brand">Marques</label>
                    <select class="form-select mb-3" name="brand[slug]" id="brand">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($brands as $brand): ?>
                            <option value="<?= $brand['slug']; ?>"><?= $brand['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label" for="type">Types</label>
                    <select class="form-select mb-3" name="type[slug]" id="type">
                        <option selected disabled value="">Aucun</option>
                        <?php foreach($types as $type): ?>
                            <option value="<?= $type['slug']; ?>"><?= $type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Valider mes filtres</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card vh-100">
            <div class="card-header">Liste des objets</div>
            <div class="card-body">
                <div class="row row-cols-md-4 g-2">
                    <?php foreach($items as $item) : ?>
                        <div class="col">
                            <div class="card">
                                <?php
                                $img_src = !empty($item['default_img_file_path']) ? base_url($item['default_img_file_path']) : base_url('assets/img/full.jpg');
                                ?>
                                <a href="<?= base_url('item/' . $item['slug']) ?>">
                                    <img src="<?= $img_src; ?>" class="card-img-top" alt="...">
                                </a>
                                <div class="car-body">
                                    <div class="card-title"><?= $item['name']; ?></div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
                      print_r($data);
                  }?>
                </pre>
                <pre>
                  <?php
                  if (isset($items)) {
                      print_r($items);
                  }?>
                </pre>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- END: OFFCANVAS -->