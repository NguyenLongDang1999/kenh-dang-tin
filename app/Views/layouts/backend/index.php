<!DOCTYPE html>
<html class="loading bordered-layout" lang="vi">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="robots" content="noindex, nofollow" />
    <?= csrf_meta() ?>
    <title>KenhDangTin - <?= $this->renderSection('title') ?></title>
    <?= $this->include('layouts/backend/link_tag') ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern">
    <!-- BEGIN: Header-->
    <?= $this->include('layouts/backend/header') ?>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <?= $this->include('layouts/backend/main-menu') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <?= $this->renderSection('content-header') ?>
            </div>
            <div class="content-body">
                <?= $this->renderSection('content-body') ?>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <?= $this->include('layouts/backend/script_tag') ?>
</body>
<!-- END: Body-->

</html>