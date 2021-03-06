<?= $this->extend('layouts/backend/index'); ?>

<!-- title -->
<?= $this->section('title'); ?>
Pages <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>
<!-- end title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/editors/quill/quill.snow.css') ?>
<?= link_tag('https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-quill-editor.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/editors/quill/quill.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';
        var pagesForm = $('#pages-form');
        if (pagesForm.length) {
            pagesForm.validate({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        <?php if (!isset($row)) : ?>
                            remote: {
                                url: "<?= route_to('admin.pages.checkExists'); ?>",
                                type: 'post',
                                dataType: 'json',
                                dataFilter: function(data) {
                                    let obj = eval('(' + data + ')');
                                    return obj.valid;
                                },
                            }
                        <?php endif ?>
                    },
                    meta_title: {
                        maxlength: 60
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
                        required: "Ti??u ????? trang kh??ng ???????c b??? tr???ng.",
                        maxlength: "Ti??u ????? trang kh??ng ???????c v?????t qu?? 255 k?? t???.",
                        <?php if (!isset($row)) : ?>
                            remote: "Ti??u ????? trang n??y ???? t???n t???i. Vui l??ng ki???m tra l???i."
                        <?php endif ?>

                    },
                    meta_title: {
                        maxlength: "Meta Title (SEO) kh??ng ???????c v?????t qu?? 60 k?? t???.",
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
                                <a href="<?= route_to('admin.pages.index') ?>" class="text-capitalize">
                                    Qu???n l?? trang
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
                <a href="<?= route_to('admin.pages.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay L???i Danh S??ch</span>
                </a>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'C???p Nh???t Trang ' . esc($row->name) : 'Th??m M???i Trang' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                        <?= form_open(route_to('admin.pages.update', esc($row->id)), ['id' => 'pages-form', 'class' => 'form-editor']) ?>
                    <?php else : ?>
                        <?= form_open(route_to('admin.pages.store'), ['id' => 'pages-form', 'class' => 'form-editor']) ?>
                    <?php endif; ?>

                    <?= form_hidden('description', '') ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Ti??u ????? trang', 'name', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('name', isset($row->name) ? $row->name : '', ['class' => 'form-control', 'id' => 'name']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('N???i dung chi ti???t trang', 'description', ['class' => 'form-label text-capitalize']) ?>
                                <div id="full-wrapper">
                                    <div id="full-container">
                                        <div class="editor">
                                            <?= isset($row) ? $row->description : '' ?>
                                        </div>
                                    </div>
                                </div>
                                <span id="description-error" class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('Meta Title (SEO)', 'meta_title', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('meta_title', isset($row->meta_title) ? $row->meta_title : '', ['class' => 'form-control', 'id' => 'meta_title', 'rows' => 3]) ?>
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
                            <?= form_button(['class' => 'btn btn-primary', 'type' => 'submit', 'content' => !isset($row) ? "Th??m M???i" : "C???p Nh???t"]) ?>
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