<?php $comment = model('Comment') ?>
<?php $sum = 0 ?>
<section class="grid-view">
    <?php foreach ($getProduct as $item) : ?>
        <?php $commentRating = $comment->getSumRatingComment($item->id) ?>

        <?php foreach ($commentRating as $row) : ?>
            <?php $sum += $row->rating ?>
        <?php endforeach; ?>

        <div class="card ecommerce-card">
            <div class="text-center position-relative">
                <a href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>">
                    <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top card-img lazy loading height-200', 'alt' => esc($item->name), 'data-src' => showProductImage(esc($item->image))]) ?>
                </a>

                <?php if ($item->featured == FEATURED_ACTIVE) : ?>
                    <div class="position-absolute top-0">
                        <span class="badge bg-primary p-75">
                            <i data-feather="zap"></i>
                            HOT
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ($item->sale !== 0) : ?>
                    <div class="position-absolute top-0 end-0">
                        <span class="badge bg-danger p-75">
                            -<?= esc($item->sale) ?>%
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="item-wrapper">
                    <div class="item-rating">
                        <ul class="unstyled-list list-inline">
                            <?php if (count($commentRating) !== 0) : ?>
                                <?= starRating($sum / count($commentRating)) ?>
                            <?php else : ?>
                                <?= starRating(0) ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <h6 class="item-name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($item->name) ?>">
                    <a class="text-body" href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>">
                        <?= esc($item->name) ?>
                    </a>
                    <span class="card-text item-company">By <a href="#" class="company-name">Apple</a></span>
                </h6>
                <p class="card-text text-description mt-50">
                    <?= esc($item->small_description) ?>
                </p>
                <ul class="list-unstyled">
                    <li><i data-feather="dollar-sign"></i> <?= esc(number_to_amount($item->price - ($item->price * ($item->sale / 100)), 2, 'vi_VN')) ?> (<span class="text-decoration-line-through text-muted"><?= $item->price !== 0 ? esc(number_to_amount($item->price, 2, 'vi_VN')) : 'Thương Lượng' ?></span>) </li>
                    <li class="text-capitalize"><i data-feather="layers"></i> <?= esc($item->catName) ?></li>
                    <li><i data-feather="code"></i> <?= esc($item->sku) ?></li>
                    <li><i data-feather="eye"></i> <?= esc($item->view) ?></li>
                    <li><i data-feather="clock"></i> <?= getDateHumanize(esc($item->created_at)) ?></li>
                </ul>
            </div>
            <div class="item-options text-center">
                <a href="#" class="btn btn-primary btn-cart" data-id="<?= esc($item->id) ?>">
                    <i data-feather="shopping-cart"></i>
                    <span class="add-to-cart">Thêm Giỏ Hàng</span>
                </a>
            </div>
        </div>
    <?php endforeach ?>
</section>