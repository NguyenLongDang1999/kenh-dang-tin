<?= $this->extend('layouts/backend/index'); ?>

<!-- title -->
<?= $this->section('title'); ?>
Category <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>
<!-- end title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';
        var categoryForm = $('#category-form');
        if (categoryForm.length) {
            categoryForm.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        <?php if (!isset($row)) : ?>
                            remote: {
                                url: "<?= route_to('admin.category.checkExists'); ?>",
                                type: 'post',
                                dataType: 'json',
                                dataFilter: function(data) {
                                    let obj = eval('(' + data + ')');
                                    return obj.valid;
                                },
                            }
                        <?php endif ?>
                    },
                    description: {
                        maxlength: 255
                    },
                    parent_id: {
                        required: true
                    },
                    meta_keyword: {
                        maxlength: 60
                    },
                    meta_description: {
                        maxlength: 160
                    },
                },
                messages: {
                    name: {
                        required: "Ti??u ????? danh m???c kh??ng ???????c b??? tr???ng.",
                        maxlength: "Ti??u ????? danh m???c kh??ng ???????c v?????t qu?? 255 k?? t???.",
                        <?php if (!isset($row)) : ?>
                            remote: "Ti??u ????? danh m???c n??y ???? t???n t???i. Vui l??ng ki???m tra l???i."
                        <?php endif ?>

                    },
                    description: {
                        maxlength: "M?? t??? danh m???c kh??ng ???????c v?????t qu?? 255 k?? t???."
                    },
                    parent_id: {
                        required: "Danh m???c cha kh??ng ???????c b??? tr???ng.",
                    },
                    meta_keyword: {
                        maxlength: "Meta Keyword (SEO) kh??ng ???????c v?????t qu?? 60 k?? t???.",
                    },
                    meta_description: {
                        maxlength: "Meta Description (SEO) kh??ng ???????c v?????t qu?? 160 k?? t???."
                    }
                },

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
                                <a href="<?= route_to('admin.dashboard.index') ?>" class="text-capitalize">
                                    Trang ch???
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= route_to('admin.category.index') ?>" class="text-capitalize">
                                    Qu???n l?? danh m???c
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                <?= isset($row) ? 'C???p Nh???t ' : 'Th??m M???i' ?>
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
<section class="bs-validation">
    <div class="row">
        <div class="col-md-12">

            <div class="mb-1">
                <a href="<?= route_to('admin.category.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay L???i Danh S??ch</span>
                </a>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'C???p Nh???t Danh M???c ' . esc($row->name) : 'Th??m M???i Danh M???c' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                        <?= form_open_multipart(route_to('admin.category.update', esc($row->id)), ['id' => 'category-form']) ?>
                    <?php else : ?>
                        <?= form_open_multipart(route_to('admin.category.store'), ['id' => 'category-form']) ?>
                    <?php endif; ?>

                    <?php if (isset($row)) : ?>
                        <?= form_hidden('checkImg', isset($row->image) ? $row->image : '') ?>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Ti??u ????? danh m???c', 'name', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('name', isset($row->name) ? $row->name : '', ['class' => 'form-control', 'id' => 'name']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('M?? t??? danh m???c', 'description', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('description', isset($row->description) ? $row->description : '', ['class' => 'form-control', 'id' => 'description']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Danh M???c Cha', 'parent_id', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_dropdown('parent_id', $option, isset($row->parent_id) ? $row->parent_id : '', ['class' => 'select2 form-control']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 validate-image">
                                <?= form_label('???nh ?????i di???n danh m???c', 'image', ['class' => 'form-label text-capitalize']) ?>
                                <div class="d-flex flex-column flex-md-row">
                                    <?= img(showCategoryImage(isset($row->image) ? $row->image : NULL), false, ['class' => 'rounded me-2 mb-1 mb-md-0', 'id' => 'blog-feature-image', 'width' => 120, 'height' => 120, 'alt' => 'Category Image']) ?>

                                    <div class="featured-info">
                                        <div class="d-inline-block">
                                            <?= form_upload('image', '', ['class' => 'form-control', 'id' => 'blogCustomFile', 'accept' => 'image/*']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Meta Keyword (SEO)', 'meta_keyword', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('meta_keyword', isset($row->meta_keyword) ? $row->meta_keyword : '', ['class' => 'form-control', 'id' => 'meta_keyword', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Meta Description (SEO)', 'meta_description', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('meta_description', isset($row->meta_description) ? $row->meta_description : '', ['class' => 'form-control', 'id' => 'meta_description', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <div class="form-check form-check-primary">
                                    <?= form_checkbox('status', '1', isset($row->status) && $row->status == STATUS_ACTIVE ? true : false, ['class' => 'form-check-input', 'id' => 'status-active']) ?>
                                    <?= form_label('Hi???n Th???', 'status-active', ['class' => 'form-check-label']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= form_button(['class' => 'btn btn-primary btn-disabled-image', 'type' => 'submit', 'content' => !isset($row) ? "Th??m M???i" : "C???p Nh???t"]) ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->