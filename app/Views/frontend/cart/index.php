<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
Giỏ hàng
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-number-input.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/app-ecommerce.min.js') ?>
<script>
    $(function() {
        'use strict';

        var quantityCounter = $('.quantity-counter'),
            CounterMin = 1,
            CounterMax = 10;

        if (quantityCounter.length > 0) {
            quantityCounter
                .TouchSpin({
                    min: CounterMin,
                    max: CounterMax
                })
                .on('touchspin.on.startdownspin', function() {
                    var $this = $(this);
                    $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
                    if ($this.val() == 1) {
                        $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
                    }
                })
                .on('touchspin.on.startupspin', function() {
                    var $this = $(this);
                    $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
                    if ($this.val() == 10) {
                        $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
                    }
                });
        }
    });
</script>
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
                                Giỏ Hàng
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
<div id="place-order" class="list-view product-checkout">
    <div class="checkout-items">
        <div class="card ecommerce-card">
            <div class="item-img">
                <a href="app-ecommerce-details.html">
                    <img src="../../../app-assets/images/pages/eCommerce/1.png" alt="img-placeholder" />
                </a>
            </div>
            <div class="card-body">
                <div class="item-name">
                    <h6 class="mb-0"><a href="app-ecommerce-details.html" class="text-body">Apple Watch Series 5</a></h6>
                    <span class="item-company">By <a href="#" class="company-name">Apple</a></span>
                    <div class="item-rating">
                        <ul class="unstyled-list list-inline">
                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                        </ul>
                    </div>
                </div>
                <span class="text-success mb-1">In Stock</span>
                <div class="item-quantity">
                    <span class="quantity-title">Qty:</span>
                    <div class="quantity-counter-wrapper">
                        <div class="input-group">
                            <input type="text" class="quantity-counter" value="1" />
                        </div>
                    </div>
                </div>
                <span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                <span class="text-success">17% off 4 offers Available</span>
            </div>
            <div class="item-options text-center">
                <div class="item-wrapper">
                    <div class="item-cost">
                        <h4 class="item-price">$19.99</h4>
                        <p class="card-text shipping">
                            <span class="badge rounded-pill badge-light-success">Free Shipping</span>
                        </p>
                    </div>
                </div>
                <button type="button" class="btn btn-light mt-1 remove-wishlist">
                    <i data-feather="x" class="align-middle me-25"></i>
                    <span>Remove</span>
                </button>
                <button type="button" class="btn btn-primary btn-cart move-cart">
                    <i data-feather="heart" class="align-middle me-25"></i>
                    <span class="text-truncate">Add to Wishlist</span>
                </button>
            </div>
        </div>
    </div>

    <div class="checkout-options">
        <div class="card">
            <div class="card-body">
                <label class="section-label form-label mb-1">Options</label>
                <div class="coupons input-group input-group-merge">
                    <input type="text" class="form-control" placeholder="Coupons" aria-label="Coupons" aria-describedby="input-coupons" />
                    <span class="input-group-text text-primary ps-1" id="input-coupons">Apply</span>
                </div>
                <hr />
                <div class="price-details">
                    <h6 class="price-title">Price Details</h6>
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
                    <hr />
                    <ul class="list-unstyled">
                        <li class="price-detail">
                            <div class="detail-title detail-total">Total</div>
                            <div class="detail-amt fw-bolder">$574</div>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-primary w-100 btn-next place-order">Place Order</button>
                </div>
            </div>
        </div>
        <!-- Checkout Place Order Right ends -->
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->