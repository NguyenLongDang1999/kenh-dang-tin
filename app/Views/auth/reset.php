<?= $this->extend('layouts/frontend/index') ?>

<!-- title -->
<?= $this->section('title') ?>
Đặt lại mật khẩu
<?= $this->endSection() ?>
<!-- end title -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<?= link_tag('app-assets/css/pages/authentication.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';

        var resetForm = $('.auth-reset-form');

        if (resetForm.length) {
            resetForm.validate({
                rules: {
                    token: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                    },
                    password: {
                        required: true,
                        maxlength: 15,
                        minlength: 8,
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                },
                messages: {
                    token: {
                        required: "Code không được bỏ trống.",
                    },
                    email: {
                        required: "Email không được bỏ trống.",
                        maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                        email: "Email không đúng định dạng.",
                    },
                    password: {
                        required: "Password không được bỏ trống.",
                        maxlength: "Password không được vượt quá 15 ký tự.",
                        minlength: "Password phải có tối thiểu 8 ký tự.",
                    },
                    confirm_password: {
                        equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại"
                    }
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
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                Đặt lại mật khẩu
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
<section class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
        <div class="card mb-0">
            <div class="card-body">
            <div class="text-center">
                    <h4 class="card-title mb-1">Đặt lại Mật Khẩu?</h4>
                    <p class="card-text mb-2 text-center">Nhập mã code bạn nhận được qua E-mail vào ô Code.</p>
                </div>

                <?= view('components/_message') ?>

                <?= form_open(route_to('reset-password'), ['class' => 'auth-reset-form mt-2']) ?>
                <div class="mb-1">
                    <?= form_label('Code', 'token', ['class' => 'form-label']) ?>
                    <?= form_input('token', '', ['class' => 'form-control', 'id' => 'token', 'placeholder' => 'Mã code nhận được qua E-mail']) ?>
                </div>

                <div class="mb-1">
                    <?= form_label('E-mail', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email']) ?>
                </div>

                <div class="mb-1">
                    <?= form_label('Mật Khẩu', 'password', ['class' => 'form-label']) ?>

                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'id' => 'password']) ?>
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>

                <div class="mb-1">
                    <?= form_label('Xác Nhận Mật Khẩu', 'confirm_password', ['class' => 'form-label']) ?>

                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('confirm_password', '', ['class' => 'form-control form-control-merge', 'id' => 'confirm_password']) ?>
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>
                <?= form_button(['class' => 'btn btn-primary w-100', 'type' => 'submit', 'content' => 'Đặt lại mật khẩu']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2">
                    <a href="<?= route_to('login') ?>">
                        <i data-feather="chevron-left"></i>
                        <small class="text-capitalize">Tới trang đăng nhập</small>
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->