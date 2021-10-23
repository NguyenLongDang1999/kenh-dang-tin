<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
Sản phẩm mới nhất tại <?= base_url() ?>
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<style>
    .text-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.script.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/app-ecommerce.min.js') ?>
<script>
    $(function() {
        $('.lazy').lazy();
    })
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
                                <a href="<?= route_to('user.category.index') ?>" class="text-capitalize">
                                    Danh mục sản phẩm
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                Sản phẩm mới nhất
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
<div class="text-center">
    <div class="divider my-3">
        <div class="divider-text">
            <h1 class="text-uppercase font-medium-5">Sản phẩm mới nhất</h1>
        </div>
    </div>
</div>

<section id="ecommerce-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="ecommerce-header-items">
                <div class="result-toggler">
                    <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
                        <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
                    </button>
                    <div class="search-results text-capitalize">Hiển thị <?= esc($countProduct) ?> sản phẩm</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="body-content-overlay"></div>

<section id="ecommerce-searchbar" class="ecommerce-searchbar mb-3">
    <div class="row mt-1">
        <div class="col-sm-12">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control search-product" id="shop-search" placeholder="Search Product" aria-label="Search..." aria-describedby="shop-search" />
                <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
            </div>
        </div>
    </div>
</section>
<?php if (count($getProductNews)) : ?>
    <?= view('components/_product', ['getProduct' => $getProductNews, 'category' => $is_ecommerce_page]) ?>

    <section id="ecommerce-pagination">
        <div class="row">
            <div class="col-sm-12">
                <?= $pager->links() ?>
            </div>
        </div>
    </section>
<?php endif; ?>
</div>
</div>
<?= view('components/_filter') ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->