<?php if ($pager->getPageCount() > 1) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <!-- Previous Button -->
            <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $pager->hasPreviousPage() ? $pager->getPreviousPage() : '#' ?>" aria-label="Précédent">
                    <span aria-hidden="true">Précédent</span>
                </a>
            </li>

            <!-- Page Numbers -->
            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>

            <!-- Next Button -->
            <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $pager->hasNextPage() ? $pager->getNextPage() : '#' ?>" aria-label="Suivant">
                    <span aria-hidden="true">Suivant</span>
                </a>
            </li>
        </ul>
    </nav>
<?php endif ?>