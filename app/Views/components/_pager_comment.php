<?php $pager->setSurroundCount(3) ?>

<?php if (count($pager->links()) > 1) { ?>
  <nav>
    <ul class="pagination justify-content-center mt-2">
      <?php if ($pager->getPreviousPage()) : ?>
        <li class="page-item"><a class="page-link" data-page="<?= $pager->getFirstPageNumber() ?>" href="<?= $pager->getFirst() ?>">Đầu</a></li>

        <li class="page-item prev-item"><a class="page-link" data-page="<?= $pager->getPreviousPageNumber() ?>" href="<?= $pager->getPreviousPage() ?>"></a></li>
      <?php endif ?>

      <?php foreach ($pager->links() as $link) : ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>" aria-current="page"><a class="page-link" data-page="<?= $link['title'] ?>" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a></li>
      <?php endforeach ?>

      <?php if ($pager->getNextPage()) : ?>
        <li class="page-item next-item"><a class="page-link" data-page="<?= $pager->getNextPageNumber() ?>" href="<?= $pager->getNextPage() ?>"></a></li>

        <li class="page-item"><a class="page-link" data-page="<?= $pager->getLastPageNumber() ?>" href="<?= $pager->getLast() ?>">Cuối</a></li>
      <?php endif ?>
    </ul>
  </nav>
<?php } ?>