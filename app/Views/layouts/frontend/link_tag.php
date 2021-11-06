<link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
<link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

<!-- BEGIN: Vendor CSS-->
<?= link_tag('app-assets/vendors/css/vendors.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/toastr.min.css') ?>
<?= $this->renderSection('vendorCSS') ?>
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<?= link_tag('app-assets/css/bootstrap.min.css') ?>
<?= link_tag('app-assets/css/bootstrap-extended.min.css') ?>
<?= link_tag('app-assets/css/colors.min.css') ?>
<?= link_tag('app-assets/css/components.min.css') ?>
<?= link_tag('app-assets/css/themes/bordered-layout.min.css') ?>
<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<?= link_tag('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') ?>
<?= link_tag('app-assets/css/plugins/extensions/ext-component-toastr.min.css') ?>
<?= $this->renderSection('pageCSS') ?>
<!-- END: Page CSS-->