<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
    <?php foreach ($getProduct as $item) : ?>
        <div class="col mb-3">
            <div class="card h-100">
                <div class="text-center position-relative">
                    <a href="<?= route_to('user.product.detail', esc($item->slug), esc($item->id)) ?>">
                        <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top card-img lazy loading', 'alt' => esc($item->name), 'data-src' => showProductImage(esc($item->image))]) ?>

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
                    </a>
                </div>
                <div class="card-body">
                    <h4 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($item->name) ?>">
                        <a class="text-body" href="<?= route_to('user.product.detail', esc($item->slug), esc($item->id)) ?>"><?= esc($item->name) ?></a>
                    </h4>
                    <div class="item-wrapper mb-50">
                        <div class="d-flex align-items-center flex-wrap">
                            <i data-feather='dollar-sign'></i>
                            <h2 class="item-price mb-0 ms-50 text-primary">
                                <?= esc(number_to_amount($item->price - ($item->price * ($item->sale / 100)), 2, 'vi_VN')) ?>
                            </h2>

                            <h5 class="item-price mb-0 ms-50 text-black-50 text-decoration-line-through">
                                <?= $item->price !== 0 ? esc(number_to_amount($item->price, 2, 'vi_VN')) : 'Thương Lượng' ?>
                            </h5>
                        </div>
                    </div>
                    <div class="item-wrapper mb-50">
                        <div class="d-flex align-items-center">
                            <i data-feather='eye'></i>
                            <h6 class="item-price mb-0 ms-50 text-black-50"><?= esc($item->view) ?></h6>
                        </div>
                    </div>
                    <p class="card-text mt-2">
                        This is a wider card with supporting text below as a natural lead-in to additional content. This content is
                        a little bit longer.
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= getDateHumanize(esc($item->created_at)) ?></small>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>