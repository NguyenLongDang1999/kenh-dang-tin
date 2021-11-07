<?php $sum = 0; ?>
<a class="nav-link" href="#" data-bs-toggle="dropdown"><i class="ficon" data-feather="shopping-cart"></i><span class="badge rounded-pill bg-primary badge-up cart-item-count"><?= esc($getListCartCount) ?></span></a>
<ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
    <li class="dropdown-menu-header">
        <div class="dropdown-header d-flex">
            <h4 class="notification-title mb-0 me-auto">Giỏ Hàng Của Tôi</h4>
            <div class="badge rounded-pill badge-light-primary"><?= esc($getListCartCount) ?> sản phẩm</div>
        </div>
    </li>
    <li class="scrollable-container media-list">
        <?php if (count($getListCart)) : ?>
            <?php foreach ($getListCart as $item) : ?>
                
                <?php $price = ($item->price - ($item->price * ($item->sale / 100))) * $item->cartQuantity; ?>
                <?php $sum += $price; ?>

                <div class="list-item align-items-center">
                    <?= img(showProductImage(esc($item->image)), false, ['class' => 'd-block rounded me-1', 'alt' => esc($item->name), 'width' => 62]) ?>
                    <div class="list-item-body flex-grow-1">
                        <div class="media-heading" style="width: 13rem">
                            <h6 class="cart-item-title">
                                <a class="text-body" href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>"><?= esc($item->name) ?></a>
                            </h6>
                            <small class="cart-item-by">SKU: <?= esc($item->sku) ?></small>
                            <small class="cart-item-by">Số Lượng: <?= esc($item->cartQuantity) ?></small>
                        </div>
                        <h5 class="cart-item-price" style="width: 7rem"><?= esc(number_to_amount($price, 2, 'vi_VN')) ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <span class="text-danger text-capitalize d-block py-1 text-center">Giỏ Hàng Trống.</span>
        <?php endif; ?>
    </li>
    <li class="dropdown-menu-footer">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="fw-bolder mb-0">Tổng Tiền:</h6>
            <h6 class="text-primary fw-bolder mb-0"><?= esc(number_to_amount($sum, 2, 'vi_VN')) ?></h6>
        </div>
        <a class="btn btn-light w-100 mb-1" href="<?= route_to('user.cart.index') ?>">Xem Giỏ Hàng</a>
        <a class="btn btn-primary w-100" href="<?= route_to('user.checkout.index') ?>">Thanh Toán</a>
    </li>
</ul>