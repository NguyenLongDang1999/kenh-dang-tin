<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
Thanh Toán Đơn Hàng
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<section id="breadcrumb-alignment">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="d-flex justify-content-start breadcrumb-wrapper shadow-none">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ms-1 d-flex">
                            <li class="breadcrumb-item">
                                <a href="<?= route_to('user.home.index') ?>" class="text-capitalize">
                                    Trang chủ
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Thanh Toán Đơn Hàng
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1 text-capitalize">Thông tin đơn đặt hàng</h4>

                    <?= form_open(route_to('user.checkout.store'), ['class' => 'checkout-form mt-2']) ?>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Họ và tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('fullname', user()->fullname, ['class' => 'form-control', 'id' => 'fullname', 'disabled' => true]) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('E-mail', 'email', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('email', user()->email, ['class' => 'form-control', 'id' => 'email', 'disabled' => true]) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Số điện thoại', 'phone', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('phone', user()->phone, ['class' => 'form-control', 'id' => 'phone', 'disabled' => true]) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Địa chỉ cư trú', 'address', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('address', user()->address, ['class' => 'form-control', 'id' => 'address', 'disabled' => true]) ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Địa chỉ giao hàng', 'address_checkout', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('address_checkout', '', ['class' => 'form-control', 'id' => 'address_checkout', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>

                    <?= form_button(['class' => 'btn btn-primary', 'type' => 'submit', 'content' => 'Xác Nhận Thanh Toán']) ?>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1 text-capitalize">Thông tin đơn đặt hàng</h4>
                    <div class="table-responsive">
                        <table class="table table-white-space">
                            <thead class="table-light">
                                <tr>
                                    <th>Hình Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá Sản Phẩm</th>
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
                                                <span id="change-price"><?= esc(number_to_amount($price, 2, 'vi_VN')) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">Giỏ Hàng Không Có Sản Phẩm</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="1">Tổng Tiền</th>
                                    <th colspan="2" class="text-end"><?= esc(number_to_amount($sum, 2, 'vi_VN')) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->