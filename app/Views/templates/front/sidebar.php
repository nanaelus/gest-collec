<nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="<?= base_url('/assets/brand/logo-bleu.svg') ?>" class="sidebar-brand-narrow" _width="32" height="32" alt="Gest-Collect" /> Gest-Collec</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <?php foreach ($menus as $km => $menu) {
                    if (isset($menu['require']) && ! $user->check($menu['require'])) { continue; }
                    if (!isset($menu['subs'])) { ?>
                        <li class="nav-item <?= ($localmenu === $km ? 'active' : '') ?>"
                            id="menu_<?= $km ?>">
                            <a class="nav-link" href="<?= base_url($menu['url']) ?>">
                                <?php if (isset($menu['icon'])) { echo $menu['icon']; }
                                else { ?><svg class="nav-icon"><span class="bullet bullet-dot"></svg><?php } ?>
                                <?= $menu['title'] ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= (isset($menu['icon'])) ? $menu['icon'] : ""; ?>
                                <?= $menu['title'] ?></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach($menu['subs'] as $ksm => $smenu) {
                                    if (isset($smenu['require']) && ! $user->check($smenu['require'])) { continue; } ?>
                                    <li id="menu_<?= $ksm ?>"><a class="dropdown-item" href="<?= base_url($smenu['url']) ?>">
                                            <?php if (isset($smenu['icon'])) echo $smenu['icon']; ?>
                                            <?= $smenu['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
        <select id="search-item-head" class="form-control me-2 w-25" name="item">LOL</select>

        <?php if (isset($user)) { ?>
            <div class="navbar-nav d-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="icon icon-lg theme-icon-active fa-solid fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="p-2"><img class="img-thumbnail mx-auto d-block" height="80px" src="<?= base_url($user->getProfileImage()); ?>"></li>
                        <li><a class="dropdown-item" href="<?= base_url('/user/' . $user->id); ?>"><i class="fa-solid fa-pencil me-2"></i>Mon profil</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/collection/' . $user->username); ?>"><i class="fa-solid fa-eye me-2"></i>Ma collection</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/login/logout'); ?>"><i class="fa-solid fa-right-from-bracket me-2"></i>Déconnexion</a></li>
                    </ul>
                </li>
            </div>
        <?php } else { ?>
            <a href="<?= base_url('/login') ?>" class="nav-link"><i class="fa-solid fa-user me-3 ms-3"></i>Connexion/Inscription</a>
        <?php } ?>
    </div>
</nav>