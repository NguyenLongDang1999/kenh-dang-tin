<?= $this->extend('layouts/backend/index'); ?>

<!-- title -->
<?= $this->section('title'); ?>
Coupon <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>
<!-- end title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/pickers/form-flat-pickr.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/cleave/cleave.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';
        var couponForm = $('#coupon-form');
        if (couponForm.length) {
            couponForm.validate({
                rules: {
                    code: {
                        required: true,
                        maxlength: 255,
                        <?php if (!isset($row)) : ?>
                            remote: {
                                url: "<?= route_to('admin.coupon.checkExists'); ?>",
                                type: 'post',
                                dataType: 'json',
                                dataFilter: function(data) {
                                    let obj = eval('(' + data + ')');
                                    return obj.valid;
                                },
                            }
                        <?php endif ?>
                    },
                    price_discount: {
                        required: true,
                        number: true,
                    },
                    code_limit: {
                        required: true,
                        number: true,
                    },
                    price_payment_limit: {
                        required: true,
                        number: true,
                    },
                    code_description: {
                        required: true,
                        maxlength: 255
                    },
                },
                messages: {
                    name: {
                        required: "Code kh??ng ???????c b??? tr???ng.",
                        maxlength: "Code kh??ng ???????c v?????t qu?? 255 k?? t???.",
                        <?php if (!isset($row)) : ?>
                            remote: "Code n??y ???? t???n t???i. Vui l??ng ki???m tra l???i."
                        <?php endif ?>

                    },
                    price_discount: {
                        required: "S??? Ti???n Gi???m Gi?? kh??ng ???????c b??? tr???ng.",
                        number: "S??? Ti???n Gi???m Gi?? ph???i l?? m???t s??? h???p l???."
                    },
                    code_limit: {
                        required: "Gi???i H???n Nh???p kh??ng ???????c b??? tr???ng.",
                        number: "Gi???i H???n Nh???p ph???i l?? m???t s??? h???p l???."
                    },
                    price_payment_limit: {
                        required: "S??? Ti???n T???i Thi???u ???????c Nh???p kh??ng ???????c b??? tr???ng.",
                        number: "S??? Ti???n T???i Thi???u ???????c Nh???p ph???i l?? m???t s??? h???p l???."
                    },
                    code_description: {
                        required: "M?? t??? code kh??ng ???????c b??? tr???ng.",
                        maxlength: "M?? t??? code kh??ng ???????c v?????t qu?? 255 k?? t???.",
                    },
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
                                <a href="<?= route_to('admin.coupon.index') ?>" class="text-capitalize">
                                    Qu???n l?? Coupon
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
                <a href="<?= route_to('admin.coupon.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay L???i Danh S??ch</span>
                </a>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'C???p Nh???t Coupon ' . esc($row->code) : 'Th??m M???i Coupon' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                        <?= form_open(route_to('admin.coupon.update', esc($row->id)), ['id' => 'coupon-form']) ?>
                    <?php else : ?>
                        <?= form_open(route_to('admin.coupon.store'), ['id' => 'coupon-form']) ?>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Code', 'code', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('code', isset($row->code) ? $row->code : '', ['class' => 'form-control', 'id' => 'code']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('S??? ti???n gi???m gi??', 'price_discount', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('price_discount', isset($row->price_discount) ? $row->price_discount : '', ['class' => 'form-control numeral-mask', 'id' => 'price_discount']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Gi???i h???n nh???p', 'code_limit', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('code_limit', isset($row->code_limit) ? $row->code_limit : '', ['class' => 'form-control', 'id' => 'code_limit']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Ng??y h???t h???n', 'expiration_date', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('expiration_date', isset($row->expiration_date) ? $row->expiration_date : '', ['class' => 'form-control flatpickr', 'id' => 'expiration_date']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('S??? ti???n t???i thi???u ???????c nh???p', 'price_payment_limit', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('price_payment_limit', isset($row->price_payment_limit) ? $row->price_payment_limit : '', ['class' => 'form-control numeral-mask-1', 'id' => 'price_payment_limit']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('M?? t??? Code', 'code_description', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('code_description', isset($row->code_description) ? $row->code_description : '', ['class' => 'form-control', 'id' => 'code_description']) ?>
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