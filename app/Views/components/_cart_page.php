<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-capitalize">Giỏ hàng của tôi</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-white-space">
                    <thead class="table-light">
                        <tr>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá Sản Phẩm</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="cart-table">
                        <?php if (count($getListCart)) : ?>
                            <?php foreach ($getListCart as $item) : ?>
                                <?php $price = ($item->price - ($item->price * ($item->sale / 100))) * $item->cartQuantity; ?>
                                <?php $sum += $price; ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>">
                                            <?= img(showProductImage(esc($item->image)), false, ['class' => 'me-75', 'height' => 50, 'width' => 50, 'alt' => esc($item->name)]) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= route_to('user.product.showDetail', esc($item->slug), esc($item->id)) ?>" class="text-description" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($item->name) ?>">
                                            <span class="fw-bold text-body"><?= esc(character_limiter($item->name, 20, '...')) ?></span>
                                        </a>
                                        <div>
                                            SKU:
                                            <strong><?= esc($item->sku) ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="quantity-counter-wrapper">
                                            <div class="input-group">
                                                <input type="text" class="quantity-counter" value="<?= esc($item->cartQuantity) ?>" data-quantity="<?= esc($item->cartQuantity) ?>" data-product="<?= esc($item->productQuantity) ?>" data-id="<?= esc($item->cartID) ?>" />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span id="change-price"><?= esc(number_to_amount($price, 2, 'vi_VN')) ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary mt-1 btn-remove-cart" data-id="<?= esc($item->cartID) ?>">
                                            <i data-feather="x" class="align-middle me-25"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-danger">Giỏ Hàng Không Có Sản Phẩm</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <label class="section-label form-label mb-1">Options</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Coupons" />
                    <button class="btn btn-outline-primary" id="button-addon2" type="button">Áp Dụng</button>
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
                        <li class="price-detail d-flex justify-content-between">
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
</div>