<?= $this->extend('layouts/frontend/index') ?>

<!-- title -->
<?= $this->section('title') ?>
Trang chủ
<?= $this->endSection() ?>
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
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>  
<?= script_tag('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
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
                                Thông tin cá nhân
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="app-user-view-account">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <?= img(showUserImage(user()->avatar), false, ['class' => 'img-fluid rounded mt-3 mb-2', 'width' => 110, 'height' => 110, 'alt' => esc(user()->fullname)]) ?>
                            <div class="user-info text-center">
                                <h4><?= user()->fullname ?></h4>
                                <span class="badge bg-light-secondary"><?= showGender(user()->gender) ?></span>
                            </div>
                        </div>
                    </div>
                    <h4 class="fw-bolder border-bottom pb-50 mb-1 mt-1">Thông Tin Chi Tiết</h4>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-75">
                                <span class="fw-bolder me-25">E-mail:</span>
                                <span><?= !empty(user()->email) ? esc(user()->email) : 'Chưa Cập Nhật' ?></span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder me-25">Số Điện Thoại:</span>
                                <span><?= !empty(user()->phone) ? esc(user()->phone) : 'Chưa Cập Nhật' ?></span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder me-25">Ngày Sinh:</span>
                                <span><?= !empty(user()->birthdate) ? esc(getDateTime(user()->birthdate)) . ' (' . esc(getAgeUser(user()->birthdate)) . ' Tuổi)' : 'Chưa Cập Nhật' ?></span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder me-25">Nghề Nghiệp:</span>
                                <span><?= !empty(user()->job) ? esc(user()->job) : 'Chưa Cập Nhật' ?></span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder me-25">Ngày Tham Gia:</span>
                                <span><?= esc(getDateTime(user()->created_at)) ?></span>
                            </li>

                            <li class="mb-75">
                                <span class="fw-bolder me-25">Địa Chỉ:</span>
                                <span><?= !empty(user()->address) ? esc(user()->address) : 'Chưa Cập Nhật' ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <ul class="nav nav-pills mb-2">
                <li class="nav-item">
                    <a class="nav-link active" id="pill-user-profile" data-bs-toggle="pill" href="#user-profile" aria-expanded="true">
                        <i data-feather="user" class="font-medium-3 m-0 me-md-50"></i>
                        <span class="fw-bold text-capitalize d-none d-md-block">Thông tin cá nhân</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pill-change-password" data-bs-toggle="pill" href="#change-password" aria-expanded="true">
                        <i data-feather="lock" class="font-medium-3 m-0 me-md-50"></i>
                        <span class="fw-bold text-capitalize d-none d-md-block">Đổi mật khẩu</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="user-profile" aria-labelledby="pill-user-profile" aria-expanded="true">
                    <div class="card">
                        <div class="card-body">
                            <?= $this->include('frontend/user/components/updateProfile') ?>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="change-password" aria-labelledby="pill-change-password" aria-expanded="true">
                    <div class="card">
                        <div class="card-body">
                            Chao ban 1
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->