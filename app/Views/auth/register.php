<?= $this->extend('layouts/frontend/index') ?>

<!-- title -->
<?= $this->section('title') ?>
Đăng ký tài khoản thành viên
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

        var registerForm = $('.auth-register-form');

        jQuery.validator.addMethod('valid_phone', function(value) {
            var regex =
                /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
            return value.trim().match(regex);
        });

        if (registerForm.length) {
            registerForm.validate({
                rules: {
                    fullname: {
                        required: true,
                        maxlength: 30,
                    },
                    phone: {
                        required: true,
                        valid_phone: true
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                        remote: {
                            url: "<?= route_to('user.auth.checkExistsEmail'); ?>",
                            type: 'post',
                            dataType: 'json',
                            dataFilter: function(data) {
                                let obj = eval('(' + data + ')');
                                return obj.valid;
                            },
                        }
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                },
                messages: {
                    fullname: {
                        required: "Họ và tên không được bỏ trống.",
                        maxlength: "Họ và tên không được vượt quá 30 ký tự.",
                    },
                    phone: {
                        required: "Số điện thoại không được bỏ trống.",
                        valid_phone: "Số điện thoại không hợp lệ.",
                    },
                    email: {
                        required: "Email không được bỏ trống.",
                        maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                        email: "Email không đúng định dạng.",
                        remote: "Email này đã tồn tại. Vui lòng nhập email khác."
                    },
                    password: {
                        required: "Password không được bỏ trống.",
                        minlength: "Password nên có độ dài từ 8 đến 20 ký tự.",
                        maxlength: "Password nên có độ dài từ 8 đến 20 ký tự."
                    },
                    confirm_password: {
                        equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại."
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
                                Đăng ký
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
                <h4 class="card-title mb-1 text-center">Đăng Ký</h4>

                <?= view('components/_message') ?>

                <?= form_open(route_to('register'), ['class' => 'auth-register-form mt-2']) ?>
                <div class="mb-1">
                    <?= form_label('Họ và tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                    <?= form_input('fullname', '', ['class' => 'form-control', 'id' => 'fullname']) ?>
                </div>

                <div class="mb-1">
                    <?= form_label('Số điện thoại', 'phone', ['class' => 'form-label text-capitalize']) ?>
                    <?= form_input('phone', '', ['class' => 'form-control', 'id' => 'phone']) ?>
                </div>

                <div class="mb-1">
                    <?= form_label('E-mail', 'email', ['class' => 'form-label text-capitalize']) ?>
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
                <?= form_button(['class' => 'btn btn-primary w-100', 'type' => 'submit', 'content' => 'Đăng Ký']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2 text-capitalize">
                    <span>Nếu bạn đã có tài khoản?</span>
                    <a href="<?= route_to('login') ?>">
                        <span>Đăng Nhập</span>
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