<div class="checkout-items" id="cart-table">
    <?php if (count($getListCart)) : ?>
        <?php foreach ($getListCart as $item) : ?>

            <?php $price = $item->price - ($item->price * ($item->sale / 100)); ?>
            <?php $sum += $price; ?>

            <div class="card ecommerce-card">
                <a href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>">
                    <?= img(showProductImage(esc($item->image)), false, ['class' => 'card-img-top card-img height-200', 'alt' => esc($item->name)]) ?>
                </a>
                <div class="card-body">
                    <div class="item-name">
                        <h6 class="mb-0"><a href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>" class="text-body"><?= esc($item->name) ?></a></h6>
                        <span class="item-company">Mã sản phẩm: <a href="#" class="company-name"><?= esc($item->sku) ?></a></span>
                        <!-- <div class="item-rating">
                                <ul class="unstyled-list list-inline">
                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                    <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                </ul>
                            </div> -->
                    </div>
                    <div class="item-quantity">
                        <span class="quantity-title">Qty:</span>
                        <div class="quantity-counter-wrapper">
                            <div class="input-group">
                                <input type="text" class="quantity-counter" value="1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-options text-center">
                    <div class="item-wrapper">
                        <div class="item-cost">
                            <h4 class="item-price"><?= esc(number_to_amount($price, 2, 'vi_VN')) ?></h4>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-1 btn-remove-cart" data-id="<?= esc($item->cartID) ?>">
                        <i data-feather="x" class="align-middle me-25"></i>
                        <span>Xóa</span>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <span class="text-danger text-capitalize d-block py-1 text-center">Giỏ Hàng Trống.</span>
    <?php endif; ?>
</div>

<div class="checkout-options">
    <div class="card">
        <div class="card-body">
            <label class="section-label form-label mb-1">Options</label>
            <div class="coupons input-group input-group-merge">
                <input type="text" class="form-control" placeholder="Coupons" aria-label="Coupons" aria-describedby="input-coupons" />
                <span class="input-group-text text-primary ps-1" id="input-coupons">Áp dụng</span>
            </div>
            <hr />
            <div class="price-details">
                <!-- <h6 class="price-title">Price Details</h6>
                    <ul class="list-unstyled">
                        <li class="price-detail">
                            <div class="detail-title">Total MRP</div>
                            <div class="detail-amt">$598</div>
                        </li>
                        <li class="price-detail">
                            <div class="detail-title">Bag Discount</div>
                            <div class="detail-amt discount-amt text-success">-25$</div>
                        </li>
                        <li class="price-detail">
                            <div class="detail-title">Estimated Tax</div>
                            <div class="detail-amt">$1.3</div>
                        </li>
                        <li class="price-detail">
                            <div class="detail-title">EMI Eligibility</div>
                            <a href="#" class="detail-amt text-primary">Details</a>
                        </li>
                        <li class="price-detail">
                            <div class="detail-title">Delivery Charges</div>
                            <div class="detail-amt discount-amt text-success">Free</div>
                        </li>
                    </ul>
                    <hr /> -->
                <ul class="list-unstyled">
                    <li class="price-detail">
                        <div class="detail-title detail-total">Tổng Tiền</div>
                        <div class="detail-amt fw-bolder"><?= esc(number_to_amount($sum, 2, 'vi_VN')) ?></div>
                    </li>
                </ul>
                <button type="button" class="btn btn-primary w-100 btn-next place-order">Thanh Toán</button>
            </div>
        </div>
    </div>
    <!-- Checkout Place Order Right ends -->
</div>