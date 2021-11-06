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
                        required: "Code không được bỏ trống.",
                        maxlength: "Code không được vượt quá 255 ký tự.",
                        <?php if (!isset($row)) : ?>
                            remote: "Code này đã tồn tại. Vui lòng kiểm tra lại."
                        <?php endif ?>

                    },
                    price_discount: {
                        required: "Số Tiền Giảm Giá không được bỏ trống.",
                        number: "Số Tiền Giảm Giá phải là một số hợp lệ."
                    },
                    code_limit: {
                        required: "Giới Hạn Nhập không được bỏ trống.",
                        number: "Giới Hạn Nhập phải là một số hợp lệ."
                    },
                    price_payment_limit: {
                        required: "Số Tiền Tối Thiểu Được Nhập không được bỏ trống.",
                        number: "Số Tiền Tối Thiểu Được Nhập phải là một số hợp lệ."
                    },
                    code_description: {
                        required: "Mô tả code không được bỏ trống.",
                        maxlength: "Mô tả code không được vượt quá 255 ký tự.",
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
                                    Trang chủ
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= route_to('admin.coupon.index') ?>" class="text-capitalize">
                                    Quản lý Coupon
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                <?= isset($row) ? 'Cập Nhật ' : 'Thêm Mới' ?>
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
                    <span>Quay Lại Danh Sách</span>
                </a>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'Cập Nhật Coupon ' . esc($row->code) : 'Thêm Mới Coupon' ?></h4>
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
                                <?= form_label('Số tiền giảm giá', 'price_discount', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('price_discount', isset($row->price_discount) ? $row->price_discount : '', ['class' => 'form-control numeral-mask', 'id' => 'price_discount']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Giới hạn nhập', 'code_limit', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('code_limit', isset($row->code_limit) ? $row->code_limit : '', ['class' => 'form-control', 'id' => 'code_limit']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Ngày hết hạn', 'expiration_date', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('expiration_date', isset($row->expiration_date) ? $row->expiration_date : '', ['class' => 'form-control flatpickr', 'id' => 'expiration_date']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Số tiền tối thiểu được nhập', 'price_payment_limit', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('price_payment_limit', isset($row->price_payment_limit) ? $row->price_payment_limit : '', ['class' => 'form-control numeral-mask-1', 'id' => 'price_payment_limit']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <?= form_label('Mô tả Code', 'code_description', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_input('code_description', isset($row->code_description) ? $row->code_description : '', ['class' => 'form-control', 'id' => 'code_description']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <div class="form-check form-check-primary">
                                    <?= form_checkbox('status', '1', isset($row->status) && $row->status == STATUS_ACTIVE ? true : false, ['class' => 'form-check-input', 'id' => 'status-active']) ?>
                                    <?= form_label('Hiển Thị', 'status-active', ['class' => 'form-check-label']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= form_button(['class' => 'btn btn-primary btn-disabled-image', 'type' => 'submit', 'content' => !isset($row) ? "Thêm Mới" : "Cập Nhật"]) ?>
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