<?= $this->extend('layouts/backend/index'); ?>

<!-- title -->
<?= $this->section('title'); ?>
Pages Reorder
<?= $this->endSection(); ?>
<!-- end title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/dragula.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/extensions/ext-component-drag-drop.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/dragula.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(document).ready(function() {
        var url_order_item = "<?= route_to('admin.pages.postOrder') ?>";

        dragula([document.querySelector('#sortable')], {
            direction: 'vertical',
            revertOnSpill: true,
        }).on('drop', function(el, container) {
            var Lists = $(container).find('.draggable');
            var reOrder = [];
            $.each(Lists, function(key, value) {
                reOrder.push({
                    'id': $(value).data('id')
                });
            });
            $(document).on('click', '#btnOrder', function() {
                updateSortCategory(el, reOrder);
            })
        });

        function updateSortCategory(item, listing) {
            var sortable = $.ajax({
                type: "post",
                url: url_order_item,
                data: {
                    new_order: listing
                },
            });
            sortable.done(function(resp) {
                resp = jQuery.parseJSON(resp);
                if (resp.result) {
                    Swal.fire({
                        icon: "success",
                        title: "Thành Công!",
                        html: resp.message,
                        confirmButtonClass: "btn btn-success",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Thất Bại!",
                        html: resp.message,
                    });
                }
            });
        }
    })
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
                                <a href="<?= route_to('admin.dashboard.index') ?>" class="text-capitalize">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= route_to('admin.pages.index') ?>" class="text-capitalize">Quản lý trang</a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                Sắp xếp trang
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
                <a href="<?= route_to('admin.pages.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay Lại Danh Sách</span>
                </a>
            </div>

            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title">Sắp Xếp Trang</h4>
                </div>

                <div class="card-body mt-2">
                    <p class="card-text">
                        Kéo & Thả để sắp xếp thứ tự các trang
                    </p>
                    <ul class="list-group" id="sortable">
                        <?php foreach ($getReorderPages as $key => $item) : ?>
                            <li class="list-group-item draggable" data-id="<?= esc($item->id) ?>">
                                <div class="d-flex">
                                    <div class="more-info">
                                        <h5 class="text-capitalize"><?= esc($item->name) ?></h5>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="row mt-2">
                        <div class="col-12">
                            <?= form_button(['class' => 'btn btn-primary', 'id' => 'btnOrder', 'type' => 'button', 'content' => 'Lưu']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->