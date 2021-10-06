$.extend($.fn.dataTable.defaults, {
    language: {
        sProcessing:
            '<button class="btn btn-outline-primary" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span><span class="ms-25 align-middle">Loading...</span></button>',
        sLengthMenu: "Hiển Thị _MENU_ Kết Quả",
        sZeroRecords: "Không Có Dữ Liệu Nào Được Hiển Thị",
        sEmptyTable: "Không Có Dữ Liệu Nào Được Hiển Thị",
        sInfoEmpty: "Hiển Thị Từ 0 Đến 0 Trong Tổng Số 0",
        sInfo: "Hiển Thị Từ _START_ Đến _END_ Trong Tổng Số _TOTAL_",
        oPaginate: {
            sFirst: "Đầu",
            sPrevious: "&nbsp;",
            sNext: "&nbsp;",
            sLast: "Cuối",
        },
    },
});

(function (window, undefined) {
    "use strict";

    // Config
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="X-CSRF-TOKEN"]').attr("content"),
        },
        async: true,
        cache: false,
    });

    // Data
    var select2_custom = $(".select2-custom"),
        select = $(".select2"),
        blogFeatureImage = $("#blog-feature-image"),
        blogImageInput = $("#blogCustomFile"),
        quillEditor = $("#full-container .editor");

    // Methods
    if (blogImageInput.length) {
        $(blogImageInput).on("change", function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            if (/\.(jpe?g|png|gif)$/i.test(files[0]["name"])) {
                reader.onload = function () {
                    if (blogFeatureImage.length) {
                        blogFeatureImage.attr("src", reader.result);
                    }
                };
                reader.readAsDataURL(files[0]);
                $("#avatar-error").remove();
                $(".btnUpdateProfile").prop("disabled", false);
            } else {
                $(".custom-avatar").append(
                    '<span class="error" id="avatar-error">Tệp này không được chấp nhận.</span>'
                );
                $(".btnUpdateProfile").prop("disabled", true);
            }
        });
    }

    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
            .select2({
                dropdownAutoWidth: true,
                width: "100%",
                placeholder: "Vui Lòng Chọn",
                dropdownParent: $this.parent(),
            })
            .change(function () {
                $(this).valid();
            });
    });

    select2_custom.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            dropdownAutoWidth: true,
            width: "100%",
            placeholder: "Vui Lòng Chọn",
            dropdownParent: $this.parent(),
            closeOnSelect: true,
        });
    });

    // Function
    function isChecked() {
        var checkAll = $("#chkAll").attr("checked");
        var flag = false;
        $("input.checkboxes").each(function (index, element) {
            if (element.checked) {
                flag = true;
            }
        });
        if (checkAll || flag) {
            flag = true;
        }
        return flag;
    }

    function notify_cancel(text = "Không Có Mục Nào Được Chọn") {
        Swal.fire({
            icon: "warning",
            title: "Cảnh Báo!",
            text: text,
        });
    }

    function notify_error(text) {
        Swal.fire({
            icon: "error",
            title: "Thất Bại!",
            html: text,
        });
    }

    function notify_success(html) {
        Swal.fire({
            icon: "success",
            title: "Thành Công!",
            html: html,
            confirmButtonClass: "btn btn-success",
        });
    }

    function deleteAllItem(data) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Xóa Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-outline-danger ms-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var deleteItem = $.ajax({
                    type: "post",
                    url: url_delete_item,
                    data: {
                        data: data,
                    },
                });
                deleteItem.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        notify_error(resp.message);
                    }
                });
            } else {
                notify_error("Chưa Có Dữ Liệu Nào Được Xóa.");
            }
        });
    }

    function restoreAllItem(data) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Khôi Phục Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-outline-danger ms-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var restoreItem = $.ajax({
                    type: "post",
                    url: url_restore_item,
                    data: {
                        data: data,
                    },
                });
                restoreItem.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        notify_error(resp.message);
                    }
                });
            } else {
                notify_error("Chưa Có Dữ Liệu Nào Được Xóa.");
            }
        });
    }

    function statusAllItem(data, status) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Cập Nhật Trạng Thái Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-outline-danger ms-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var updateStatus = $.ajax({
                    type: "post",
                    url: url_status_item,
                    data: {
                        data: data,
                        status: status,
                    },
                });
                updateStatus.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        notify_error(resp.message);
                    }
                });
            } else {
                notify_error("Chưa Có Dữ Liệu Nào Được Cập Nhật.");
            }
        });
    }

    // Event
    $(document).on("click", "#btn-delete", function () {
        isChecked()
            ? deleteAllItem($("#frmTbList").serialize())
            : notify_cancel();
    });

    $(document).on("click", "#btn-restore", function () {
        isChecked()
            ? restoreAllItem($("#frmTbList").serialize())
            : notify_cancel();
    });

    $(document).on("click", ".btn-status", function () {
        isChecked()
            ? statusAllItem($("#frmTbList").serialize(), $(this).data("status"))
            : notify_cancel();
    });
})(window);
