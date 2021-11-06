<?= $this->extend('layouts/frontend/index') ?>

<!-- title -->
<?= $this->section('title') ?>
Quên mật khẩu
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

        var forgotForm = $('.auth-forgot-form');

        if (forgotForm.length) {
            forgotForm.validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                    }
                },
                messages: {
                    email: {
                        required: "Email không được bỏ trống.",
                        maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                        email: "Email không đúng định dạng.",
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
                                Quên mật khẩu
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
                <h4 class="card-title mb-1 text-center">Quên Mật Khẩu</h4>
                <p class="card-text mb-2 text-center">Nhập E-mail của bạn đã đăng ký và chúng tôi sẽ gửi hướng dẫn để đặt lại mật khẩu của bạn.</p>

                <?= view('components/_message') ?>

                <?= form_open(route_to('forgot'), ['class' => 'auth-forgot-form mt-2']) ?>
                <div class="mb-1">
                    <?= form_label('E-mail', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email']) ?>
                </div>
                <?= form_button(['class' => 'btn btn-primary w-100', 'type' => 'submit', 'content' => 'Gửi']) ?>
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