<?= $this->extend('layouts/backend/index') ?>

<!-- Title -->
<?= $this->section('title') ?>
Coupon List Page
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
    var couponTable = $('.coupon-table');
    var url_delete_item = "<?= route_to('admin.coupon.multiPurgeDestroy') ?>";
    var url_status_item = "<?= route_to('admin.coupon.multiStatus') ?>";
    var click_mode = 0;
    var aLengthMenuGeneral = [
        [20, 50, 100, 500, 1000],
        [20, 50, 100, 500, 1000]
    ];

    if (couponTable.length) {
        var oTable = couponTable.DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('admin.coupon.getList') ?>",
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
                    data: 'infoCoupon',
                    "bSortable": false
                },
                {
                    data: 'user_used',
                    "bSortable": false
                },
                {
                    data: 'status',
                    "bSortable": false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'action',
                    "bSortable": false
                },
            ],
            "fnServerParams": function(aoData) {
                if (click_mode == 0) {
                    aoData.push({
                        "name": "search[code]",
                        "value": $('#frmSearch input[name="search[code]"]').val()
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
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var $status_number = full['status'];
                        var $status = {
                            <?= STATUS_ACTIVE ?>: {
                                title: 'ON',
                                class: 'badge-light-primary'
                            },
                            <?= STATUS_INACTIVE ?>: {
                                title: 'OFF',
                                class: ' badge-light-danger'
                            },
                        };
                        if (typeof $status[$status_number] === 'undefined') {
                            return data;
                        }
                        return (
                            '<span class="badge badge-pill ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            '</span>'
                        );
                    }
                },
                {
                    targets: -1,
                    title: 'Thao T??c',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var $path = full['editPages'];
                        return (
                            '<a href="' + $path + '" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
                        );
                    }
                }
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

    $(document).ready(function() {
        $('#btn-frm-search').on('click', function() {
            click_mode = 0;
            oTable.draw();
        });

        $('#btn-reset').on('click', function() {
            click_mode = 1;
            $('#frmSearch select[name="search[status]"]').val('').trigger("change");
            oTable.draw();
        });
    });

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
                                <a href="<?= route_to('admin.coupon.index') ?>" class="text-capitalize">
                                    Qu???n l?? Coupon
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize active" aria-current="page">
                                Danh s??ch
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

            <div class="mb-2 d-flex justify-content-sm-between justify-content-center flex-wrap">
                <div class="mb-sm-0 mb-25">
                    <a href="<?= route_to('admin.coupon.create') ?>" class="btn btn-icon btn-outline-primary">
                        <i data-feather="plus"></i>
                        <span>Th??m M???i</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title text-capitalize">Qu???n l?? Coupon</h4>
                </div>
                <div class="card-body mt-2">
                    <?= form_open(route_to('admin.coupon.getList'), ['id' => 'frmSearch', 'method' => 'GET', 'onsubmit' => 'return false;']) ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <?= form_label('Coupon', 'search[code]', ['class' => 'form-label text-capitalize']) ?>
                                        <?= form_input('search[code]', '', ['class' => 'form-control']) ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <?= form_label('Tr???ng th??i', 'search[status]', ['class' => 'form-label text-capitalize']) ?>
                                        <?= form_dropdown('search[status]', getOptionSelectStatus(), '', ['class' => 'form-control select2-custom', 'data-minimum-results-for-search' => 'Infinity']) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-md-12 text-center">
                                    <?= form_button(['class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'content' => 'Search', 'id' => 'btn-frm-search']) ?>
                                    <?= form_button(['class' => 'btn btn-sm btn-warning', 'type' => 'reset', 'content' => 'Reset', 'id' => 'btn-reset']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
                <hr class="my-0" />
                <div class="card-header border-bottom p-1 d-flex justify-content-sm-between justify-content-center">
                    <div class="dt-action-buttons">
                        <div class="dt-buttons m-0">
                            <?= form_button(['class' => 'btn btn-outline-danger waves-effect', 'content' => '<i data-feather="trash" class="me-25"></i><span>X??a V??nh Vi???n</span>', 'id' => 'btn-delete']) ?>
                        </div>
                    </div>

                    <div class="dt-action-buttons">
                        <div class="dt-buttons m-0">
                            <?= form_button(['class' => 'btn btn-outline-primary waves-effect btn-status mx-25', 'content' => '<i data-feather="refresh-ccw" class="me-25"></i><span>Status ON</span>', 'data-status' => STATUS_ACTIVE]) ?>
                            <?= form_button(['class' => 'btn btn-outline-primary waves-effect btn-status', 'content' => '<i data-feather="refresh-ccw" class="me-25"></i><span>Status OFF</span>', 'data-status' => STATUS_INACTIVE]) ?>
                        </div>
                    </div>
                </div>
                <div class="card-datatable">
                    <?= form_open('', ['id' => 'frmTbList']) ?>
                    <table class="dt-advanced-search dt-responsive table coupon-table table-white-space">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Th??ng Tin Coupon</th>
                                <th>S??? ng?????i ???? nh???p</th>
                                <th>Tr???ng Th??i</th>
                                <th>Ng??y T???o</th>
                                <th>Ng??y S???a</th>
                                <th>Thao T??c</th>
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