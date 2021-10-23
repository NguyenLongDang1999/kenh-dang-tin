<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
Tất cả danh mục sản phẩm tại <?= base_url() ?>
<?= $this->endSection(); ?>

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
                                Tất cả danh mục
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<div class="text-center">
    <div class="divider my-3">
        <div class="divider-text">
            <h1 class="text-uppercase font-medium-5">Tất cả danh mục sản phẩm</h1>
        </div>
    </div>
</div>
<section id="category-page">
    <div class="row kb-search-content-info match-height">
        <?php foreach ($getCategoryList as $item) : ?>
            <?php $categories = model('category') ?>
            <?php $getCategoryRecursive = $categories->getCategoryRecursive($item->id); ?>
            <?php $getCategoryParent = $categories->getCategoryListParent($getCategoryRecursive); ?>
            <div class="col-lg-4 col-md-6 col-12 kb-search-content">
                <div class="card">
                    <div class="card-body">
                        <h6 class="kb-title">
                            <?= img(showCategoryImage($item->image), false, ['alt' => esc($item->name), 'class' => 'round', 'width' => '40', 'height' => '40']) ?>
                            <a href="<?= route_to('user.category.category', esc($item->slug), esc($item->id)) ?>" class="text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($item->name) ?>">
                                <span class="text-capitalize"><?= esc($item->name) ?></span>
                            </a>
                        </h6>

                        <div class="list-group list-group-circle mt-2">
                            <?php foreach ($getCategoryParent as $category) : ?>
                                <a href="<?= route_to('user.category.category', esc($category->slug), esc($category->id)) ?>" class="list-group-item text-body">
                                    <span class="text-capitalize" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($category->name) ?>">
                                        <?= esc($category->name) ?>
                                    </span>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->r