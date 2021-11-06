<!-- BEGIN: Vendor JS-->
<?= script_tag('app-assets/vendors/js/vendors.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/toastr.min.js') ?>
<?= $this->renderSection('vendorJS') ?>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<?= script_tag('app-assets/js/core/app-menu.min.js') ?>
<?= script_tag('app-assets/js/core/app.min.js') ?>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<?= script_tag('assets/js/scripts.js') ?>
<?= $this->renderSection('pageJS') ?>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>