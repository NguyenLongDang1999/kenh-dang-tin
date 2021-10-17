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
</style>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
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

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<?= $this->endSection(); ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<?php if (count($getListCategory)) : ?>
    <section>
        <div class="divider my-3">
            <div class="divider-text">
                <h3 class="text-uppercase font-medium-5">Danh mục sản phẩm</h3>
            </div>
        </div>

        <div class="row">
            <?php foreach ($getListCategory as $item) : ?>
                <div class="col-xl-2 col-md-4 col-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="avatar bg-light-info p-50 mb-1">
                                <div class="avatar-content">
                                    <a href="<?= route_to('user.category.category', esc($item->slug), esc($item->id)) ?>">
                                        <?= img(showCategoryImage($item->image), false, ['width' => 50, 'height' => 50, 'alt' => esc($item->name)]) ?>
                                    </a>
                                </div>
                            </div>
                            <h4 class="text-capitalize">
                                <a href="<?= route_to('user.category.category', esc($item->slug), esc($item->id)) ?>" class="fw-bolder text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($item->name) ?>">
                                    <?= esc($item->name) ?>
                                </a>
                            </h4>
                            <p class="card-text text-description"><?= esc($item->description) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
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