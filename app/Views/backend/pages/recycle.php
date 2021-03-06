<?= $this->extend('layouts/backend/index') ?>

<!-- Title -->
<?= $this->section('title') ?>
Pages List Recycle Page
<?= $this->endSection() ?>
<!-- end Title -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    var pagesTable = $('.pages-table');
    var url_delete_item = "<?= route_to('admin.pages.multiPurgeDestroy') ?>";
    var url_restore_item = "<?= route_to('admin.pages.multiRestore') ?>";
    var click_mode = 0;
    var aLengthMenuGeneral = [
        [20, 50, 100, 500, 1000],
        [20, 50, 100, 500, 1000]
    ];

    if (pagesTable.length) {
        var oTable = pagesTable.DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('admin.pages.getListRecycle') ?>",
            "bDeferRender": true,
            "bFilter": false,
            "bDestroy": true,
            "aLengthMenu": aLengthMenuGeneral,
            "iDisplayLength": 20,
            "bSort": true,
            "aaSorting": [
                [5, "desc"]
            ],
            columns: [{
                    data: 'checkbox',
                    "bSortable": false
                },
                {
                    data: 'responsive_id',
                    "bSortable": false
                },
                {
                    data: 'name',
                },
                {
                    data: 'url',
                    "bSortable": false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
            ],
            "fnServerParams": function(aoData) {
                if (click_mode == 0) {
                    aoData.push({
                        "name": "search[name]",
                        "value": $('#frmSearch input[name="search[name]"]').val()
                    });
                    aoData.push({
                        "name": "search[status]",
                        "value": $('#frmSearch select[name="search[status]"]').val()
                    });
                }
            },
            columnDefs: [{
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0
                },
                {
                    targets: 1,
                    orderable: false,
                    responsivePriority: 3,
                    render: function(data, type, full, meta) {
                        return (
                            '<div class="form-check"> <input class="form-check-input dt-checkboxes checkboxes" type="checkbox" name="chk[]" value="' + $('<div/>').text(data).html() + '" id="checkbox' +
                            data +
                            '" /><label class="form-check-label" for="checkbox' +
                            data +
                            '"></label></div>'
                        );
                    },
                    checkboxes: {
                        selectAllRender: '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="chkAll" /><label class="form-check-label" for="chkAll"></label></div>'
                    }
                },
            ],
            select: 'multi',
            dom: 'r <"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Chi ti???t th??ng tin ' + data['title'];
                        }
                    }),
                    type: 'column',
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.title !== '' ?
                                '<tr data-dt-row="' +
                                col.rowIdx +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>' :
                                '';
                        }).join('');

                        return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                    }
                }
            },
        });
    }

    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: "success",
            title: 'Th??nh C??ng!',
            html: "<?= session()->getFlashdata('success') ?>",
            confirmButtonClass: 'btn btn-success',
        })
    <?php endif ?>
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
                                    Trang ch???
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= route_to('admin.pages.index') ?>" class="text-capitalize">
                                    Qu???n l?? trang
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                Th??ng r??c
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
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">

            <div class="mb-1">
                <a href="<?= route_to('admin.pages.index') ?>" class="btn btn-icon btn-outline-danger">
                    <i data-feather="arrow-left"></i>
                    <span>Quay L???i Danh S??ch</span>
                </a>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title text-capitalize">Qu???n l?? th??ng r??c trang</h4>
                </div>
                <div class="card-header border-bottom p-1 d-flex justify-content-sm-between justify-content-center">
                    <div class="dt-action-buttons">
                        <div class="dt-buttons">
                            <?= form_button(['class' => 'btn btn-outline-danger waves-effect', 'content' => '<i data-feather="trash" class="me-25"></i><span>X??a V??nh Vi???n</span>', 'id' => 'btn-delete']) ?>
                        </div>
                    </div>

                    <div class="dt-action-buttons">
                        <div class="dt-buttons">
                            <?= form_button(['class' => 'btn btn-outline-primary waves-effect mx-25', 'content' => '<i data-feather="repeat" class="me-25"></i><span>Kh??i Ph???c</span>', 'id' => 'btn-restore']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-datatable">
                    <?= form_open('', ['id' => 'frmTbList']) ?>
                    <table class="dt-advanced-search dt-responsive table pages-table table-white-space">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Ti??u ?????</th>
                                <th>URL</th>
                                <th>Ng??y T???o</th>
                                <th>Ng??y S???a</th>
                            </tr>
                        </thead>
                    </table>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->