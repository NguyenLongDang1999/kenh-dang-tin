<?= $this->extend('layouts/backend/index'); ?>

<!-- title -->
<?= $this->section('title'); ?>
Product <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>
<!-- end title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
<?= link_tag('app-assets/vendors/css/editors/quill/quill.snow.css') ?>
<?= link_tag('app-assets/vendors/css/image-uploader/image-uploader.min.css') ?>
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
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/cleave/cleave.min.js') ?>
<?= script_tag('app-assets/vendors/js/editors/quill/quill.min.js') ?>
<?= script_tag('app-assets/vendors/js/image-uploader/image-uploader.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';
        var productForm = $('#product-form');
        if (productForm.length) {
            productForm.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        <?php if (!isset($row)) : ?>
                            remote: {
                                url: "<?= route_to('admin.product.checkExists'); ?>",
                                type: 'post',
                                dataType: 'json',
                                dataFilter: function(data) {
                                    let obj = eval('(' + data + ')');
                                    return obj.valid;
                                },
                            }
                        <?php endif ?>
                    },
                    sku: {
                        required: true,
                        maxlength: 255,
                    },
                    price: {
                        number: true,
                    },
                    sale: {
                        number: true,
                        min: 0,
                        max: 100
                    },
                    quantity: {
                        number: true,
                    },
                    cat_id: {
                        required: true
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
                        required: "T??n s???n ph???m kh??ng ???????c b??? tr???ng.",
                        maxlength: "T??n s???n ph???m kh??ng ???????c v?????t qu?? 255 k?? t???.",
                        <?php if (!isset($row)) : ?>
                            remote: "T??n s???n ph???m n??y ???? t???n t???i. Vui l??ng ki???m tra l???i."
                        <?php endif ?>

                    },
                    sku: {
                        required: "M?? s???n ph???m kh??ng ???????c b??? tr???ng.",
                        maxlength: "M?? s???n ph???m kh??ng ???????c v?????t qu?? 255 k?? t???.",
                    },
                    price: {
                        number: "Gi?? c??? ph???i l?? m???t s??? h???p l???."
                    },
                    sale: {
                        number: "Gi???m gi?? ph???i l?? m???t s??? h???p l???.",
                        min: "Gi???m gi?? n??n t??? 1 -> 100",
                        max: "Gi???m gi?? n??n t??? 1 -> 100"
                    },
                    quantity: {
                        number: "S??? l?????ng ph???i l?? m???t s??? h???p l???."
                    },
                    cat_id: {
                        required: "Danh m???c kh??ng ???????c b??? tr???ng.",
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

<?php if (isset($row)) : ?>
    <script>
        var url_deleteProductImage = "<?= route_to('admin.product.deleteProductImage') ?>";
        let preloaded = [
            <?php if (!empty($gallery[0])) : ?>
                <?php foreach ($gallery as $img) : ?> {
                        id: <?= $count++ ?>,
                        src: '<?= showProductMultiImage(esc($img), false) ?>'
                    },
                <?php endforeach; ?>
            <?php endif; ?>
        ];

        $('.input-images-2').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old',
            maxFiles: 12,
            maxSize: 10 * 1024 * 1024,
            label: 'K??o th??? ho???c ch???n h??nh v??o ????y',
            extensions: [".jpg", ".jpeg", ".png", ".gif"],
        });

        $(document).ready(function() {
            $('.delete-image').on('click', function() {
                var url_img = $(this).prev().attr('src');
                var product_id = "<?= esc($row->id) ?>";

                $.ajax({
                    url: url_deleteProductImage,
                    type: "post",
                    data: {
                        product_id: product_id,
                        url_img: url_img,
                    },
                }).done(function(data) {
                    data = jQuery.parseJSON(data);
                });
            });
        });
    </script>
<?php endif; ?>
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
                                <a href="<?= route_to('admin.product.index') ?>" class="text-capitalize">
                                    Qu???n l?? s???n ph???m
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
                <a href="<?= route_to('admin.product.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay L???i Danh S??ch</span>
                </a>
            </div>

            <?php if (isset($row)) : ?>
                <?= form_open_multipart(route_to('admin.product.update', esc($row->id)), ['id' => 'product-form', 'class' => 'form-editor']) ?>
            <?php else : ?>
                <?= form_open_multipart(route_to('admin.product.store'), ['id' => 'product-form', 'class' => 'form-editor']) ?>
            <?php endif; ?>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">Th??ng Tin S???n Ph???m</h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                        <?= form_hidden('checkImg', isset($row->image) ? $row->image : '') ?>
                    <?php endif ?>

                    <?= form_hidden('description', '') ?>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('T??n s???n ph???m', 'name', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('name', isset($row->name) ? $row->name : '', ['class' => 'form-control', 'id' => 'name']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Danh M???c', 'cat_id', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_dropdown('cat_id', $option, isset($row->cat_id) ? $row->cat_id : '', ['class' => 'select2 form-control']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('M?? s???n ph???m (SKU)', 'sku', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('sku', isset($row->sku) ? $row->sku : '', ['class' => 'form-control', 'id' => 'sku']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Gi?? c???', 'price', ['class' => 'form-label text-capitalize']) ?>
                                <div class="input-group">
                                    <?= form_input('price', isset($row->price) ? $row->price : '0', ['class' => 'form-control numeral-mask', 'id' => 'price']) ?>
                                    <span class="input-group-text">VN??</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Th????ng hi???u', 'brand_id', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_dropdown('brand_id', $option, isset($row->brand_id) ? $row->brand_id : '', ['class' => 'select2 form-control']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Gi???m gi??', 'sale', ['class' => 'form-label text-capitalize']) ?>
                                <div class="input-group">
                                    <?= form_input('sale', isset($row->sale) ? $row->sale : '0', ['class' => 'form-control', 'id' => 'sale']) ?>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('S??? l?????ng', 'quantity', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('quantity', isset($row->quantity) ? $row->quantity : '0', ['class' => 'form-control', 'id' => 'quantity']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">M?? T??? S???n Ph???m</h4>
                </div>

                <div class="card-body mt-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <?= form_label('M?? t??? ng???n s???n ph???m', 'small_description', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('small_description', isset($row->small_description) ? $row->small_description : '', ['class' => 'form-control', 'id' => 'small_description', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2">
                                <?= form_label('M?? t??? chi ti???t s???n ph???m', 'large_description', ['class' => 'form-label text-capitalize']) ?>
                                <div id="full-wrapper">
                                    <div id="full-container">
                                        <div class="editor">
                                            <?= isset($row->large_description) ? $row->large_description : '' ?>
                                        </div>
                                    </div>
                                </div>
                                <span id="description-error" class="error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">???nh S???n Ph???m</h4>
                </div>

                <div class="card-body mt-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 validate-image">
                                <?= form_label('???nh ?????i di???n s???n ph???m', 'image', ['class' => 'form-label text-capitalize']) ?>
                                <div class="d-flex flex-column flex-md-row">
                                    <?= img(showProductImage(isset($row->image) ? $row->image : NULL), false, ['class' => 'rounded me-2 mb-1 mb-md-0', 'id' => 'blog-feature-image', 'width' => 120, 'height' => 120, 'alt' => 'Product Image']) ?>

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
                            <div class="mb-2">
                                <?= form_label('H??nh k??m theo s???n ph???m', 'image_list', ['class' => 'form-label text-capitalize']) ?>
                                <ul>
                                    <li>Ch??? ???????c ????ng t???i ??a 12 ???nh v???i 1 s???n ph???m.</li>
                                    <li>N??n s??? d???ng h??nh ???nh li??n quan nh???t t???i s???n ph???m.</li>
                                </ul>

                                <div class="<?= isset($row->image_list) ? 'input-images-2' : 'input-images-1' ?>" style="padding-top: .5rem;"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">Meta SEO</h4>
                </div>

                <div class="card-body mt-2">
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
                </div>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">Tr???ng Th??i S???n Ph???m</h4>
                </div>

                <div class="card-body mt-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <div class="form-check form-check-primary">
                                    <?= form_checkbox('featured', '1', isset($row->featured) && $row->featured == FEATURED_ACTIVE ? true : false, ['class' => 'form-check-input', 'id' => 'featured-active']) ?>
                                    <?= form_label('N???i B???t', 'featured-active', ['class' => 'form-check-label']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <div class="form-check form-check-primary">
                                    <?= form_checkbox('status', '1', isset($row->status) && $row->status == STATUS_ACTIVE ? true : false, ['class' => 'form-check-input', 'id' => 'status-active']) ?>
                                    <?= form_label('Hi???n Th???', 'status-active', ['class' => 'form-check-label']) ?>
                                </div>
                            </div>
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
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->