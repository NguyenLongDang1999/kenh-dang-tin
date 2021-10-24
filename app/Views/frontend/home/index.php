<?= $this->extend('layouts/frontend/index') ?>

<!-- Title -->
<?= $this->section('title') ?>
Home Page
<?= $this->endSection() ?>
<!-- end Title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<style>
    .text-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ecommerce-application .grid-view {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr !important;
        -webkit-column-gap: 1rem !important;
        -moz-column-gap: 1rem !important;
        column-gap: 1rem !important;
    }

    @media (max-width: 991.98px) {
        .ecommerce-application .grid-view {
            grid-template-columns: 1fr 1fr 1fr !important;
        }
    }

    @media (max-width: 575.98px) {
        .ecommerce-application .grid-view {
            grid-template-columns: 1fr 1fr !important;
        }
    }
</style>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.script.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        $('.lazy').lazy();
    })
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<?php if (count($getListCategory)) : ?>
    <section>
        <div class="divider my-3">
            <div class="divider-text">
                <h3 class="text-uppercase font-medium-5">Danh mục sản phẩm</h3>
            </div>
        </div>

        <?= view('components/_category', ['getCategory' => $getListCategory]) ?>
    </section>
<?php endif ?>

<?php if (count($getProductFeatured)) : ?>
    <section>
        <div class="divider my-3">
            <div class="divider-text">
                <h3 class="text-uppercase font-medium-5">Sản phẩm nổi bật</h3>
            </div>
        </div>

        <?= view('components/_product', ['getProduct' => $getProductFeatured]) ?>
    </section>
<?php endif ?>

<?php if (count($getProductNew)) : ?>
    <section>
        <div class="divider my-3">
            <div class="divider-text">
                <h3 class="text-uppercase font-medium-5">Sản phẩm mới nhất</h3>
            </div>
        </div>

        <?= view('components/_product', ['getProduct' => $getProductNew]) ?>
    </section>
<?php endif ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->