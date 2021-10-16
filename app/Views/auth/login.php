<?= $this->extend('layouts/frontend/index') ?>

<!-- title -->
<?= $this->section('title') ?>
Đăng nhập thành viên
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

        var loginForm = $('.auth-login-form');

        if (loginForm.length) {
            loginForm.validate({
                rules: {
                    login: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    }
                },
                messages: {
                    login: {
                        required: "Email không được bỏ trống.",
                        email: "Email không đúng định dạng."
                    },
                    password: {
                        required: "Password không được bỏ trống.",
                        minlength: "Password nên có độ dài từ 8 đến 20 ký tự.",
                        maxlength: "Password nên có độ dài từ 8 đến 20 ký tự."
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
                                Đăng nhập
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
                <h4 class="card-title mb-1 text-center">Đăng Nhập</h4>

                <?= view('components/_message') ?>

                <?= form_open(route_to('login'), ['class' => 'auth-login-form mt-2']) ?>
                <div class="mb-1">
                    <?= form_label('E-mail', 'login', ['class' => 'form-label']) ?>
                    <?= form_input('login', '', ['class' => 'form-control', 'id' => 'login']) ?>
                </div>

                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <?= form_label('Mật Khẩu', 'password', ['class' => 'form-label']) ?>

                        <a href="<?= route_to('forgot') ?>">
                            <small>Quên Mật Khẩu?</small>
                        </a>
                    </div>

                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'id' => 'password']) ?>
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>

                <div class="mb-1">
                    <div class="form-check">
                        <input class="form-check-input" name="remember" type="checkbox" id="remember" tabindex="3" />
                        <label class="form-check-label" for="remember"> Nhớ Mật Khẩu </label>
                    </div>
                </div>
                <?= form_button(['class' => 'btn btn-primary w-100', 'type' => 'submit', 'content' => 'Đăng Nhập']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2 text-capitalize">
                    <span>Nếu bạn chưa có tài khoản?</span>
                    <a href="<?= route_to('register') ?>">
                        <span>Đăng ký</span>
                    </a>
                </p>

                <div class="divider my-2">
                    <div class="divider-text">Hoặc</div>
                </div>

                <div class="auth-footer-btn d-flex justify-content-center">
                    <a href="<?= route_to('user.auth.socialLogin') ?>?provider=facebook" class="btn btn-facebook">
                        <i data-feather="facebook"></i>
                    </a>
                    <a href="#" class="btn btn-twitter white">
                        <i data-feather="twitter"></i>
                    </a>
                    <a href="<?= route_to('user.auth.socialLogin') ?>?provider=google" class="btn btn-google">
                        <i data-feather="mail"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->