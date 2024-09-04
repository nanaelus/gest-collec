<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <img src="/assets/brand/logo-blanc.svg" class="sidebar-brand-full" _width="88" height="32" alt="Gest-Collect" />
            <img src="/assets/brand/logo-blanc.svg" class="sidebar-brand-narrow" _width="32" height="32" alt="Gest-Collect" />
            Gest-Collect
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <?php
        foreach ($menus as $km => $menu) {
            if (isset($menu['admin']) && ! $user->isAdmin()) { continue; }
            if (isset($menu['require']) && ! $user->check($menu['require'])) { continue; }
            if (!isset($menu['subs'])) { ?>
                <li class="nav-item <?= ($localmenu === $km ? 'active' : '') ?>"
                    id="menu_<?= $km ?>">
                    <a class="nav-link" href="<?= $menu['url'] ?>">
                        <?php if (isset($menu['icon'])) { echo $menu['icon']; }
                        else { ?><svg class="nav-icon"><span class="bullet bullet-dot"></svg><?php } ?>
                        <?= $menu['title'] ?>
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-group">
                    <a class="nav-link nav-group-toggle" href="#">
                        <?= (isset($menu['icon'])) ? $menu['icon'] : ""; ?>
                        <?= $menu['title'] ?></a>
                    <ul class="nav-group-items compact">
                        <?php
                        foreach($menu['subs'] as $ksm => $smenu) {

                            if (isset($smenu['admin']) && ! $user->isAdmin()) { continue; }
                            if (isset($smenu['require']) && ! $user->check($smenu['require'])) { continue; } ?>
                            <li class="nav-item" id="menu_<?= $ksm ?>"><a class="nav-link" href="<?= $smenu['url'] ?>">
                                    <?php if (isset($smenu['icon'])) echo $smenu['icon']; ?>
                                    <?= $smenu['title'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php }} ?>

        <li class="nav-item mt-auto">
            <a class="nav-link" href="/login/logout">
                <svg class="nav-icon me-2">
                    <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                </svg> Déconnexion</a>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">

        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>