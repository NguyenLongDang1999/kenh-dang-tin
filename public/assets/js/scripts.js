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
    const altFormat = "d-m-Y";
    var select2_custom = $(".select2-custom"),
        select = $(".select2"),
        blogFeatureImage = $("#blog-feature-image"),
        blogImageInput = $("#blogCustomFile"),
        quillEditor = $("#full-container .editor"),
        numeralMask = $(".numeral-mask"),
        inputImagesStore = $(".input-images-1"),
        flatPicker = $(".flatpickr"),
        rating = $(".rating");

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
                $("#image-error").remove();
                $(".btn-disabled-image").prop("disabled", false);
            } else {
                $(".validate-image").append(
                    '<span class="error" id="image-error">Tệp này không được chấp nhận.</span>'
                );
                $(".btn-disabled-image").prop("disabled", true);
            }
        });
    }

    if (flatPicker.length) {
        flatPicker.flatpickr({
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat,
            allowInput: true,
            locale: {
                months: {
                    longhand: [
                        "Tháng 1",
                        "Tháng 2",
                        "Tháng 3",
                        "Tháng 4",
                        "Tháng 5",
                        "Tháng 6",
                        "Tháng 7",
                        "Tháng 8",
                        "Tháng 9",
                        "Tháng 10",
                        "Tháng 11",
                        "Tháng 12",
                    ],
                },
            },
            onReady: function (selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).attr("step", null);
                }
            },
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

    function showCart() {
        $.ajax({
            url: "/showCart",
            type: "post",
        }).done(function (data) {
            $(".dropdown-cart").html(data);

            if ($(".dropdown-cart .scrollable-container.media-list").length) {
                const updateFavorites = new PerfectScrollbar(
                    ".dropdown-cart .scrollable-container.media-list"
                );
                updateFavorites.update();
            }

            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14,
                });
            }
        });
    }

    function showCartPage() {
        $.ajax({
            url: "/showCartPage",
            type: "post",
        }).done(function (data) {
            $("#place-order").html(data);

            var quantityCounter = $(".quantity-counter"),
                CounterMin = 1,
                CounterMax = 10;

            if (quantityCounter.length > 0) {
                quantityCounter
                    .TouchSpin({
                        min: CounterMin,
                        max: CounterMax,
                    })
                    .on("touchspin.on.startdownspin", function () {
                        var $this = $(this);
                        $(".bootstrap-touchspin-up").removeClass(
                            "disabled-max-min"
                        );
                        if ($this.val() == 1) {
                            $(this)
                                .siblings()
                                .find(".bootstrap-touchspin-down")
                                .addClass("disabled-max-min");
                        }
                    })
                    .on("touchspin.on.startupspin", function () {
                        var $this = $(this);
                        $(".bootstrap-touchspin-down").removeClass(
                            "disabled-max-min"
                        );
                        if ($this.val() == 10) {
                            $(this)
                                .siblings()
                                .find(".bootstrap-touchspin-up")
                                .addClass("disabled-max-min");
                        }
                    });
            }

            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14,
                });
            }
        });
    }

    function cartAllItem(product_id) {
        var updateCart = $.ajax({
            type: "post",
            url: url_cart_item,
            data: {
                product_id: product_id,
            },
        });
        updateCart.done(function (resp) {
            resp = jQuery.parseJSON(resp);
            if (resp.result) {
                toastr["success"]("", resp.message, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            } else {
                toastr["error"]("", resp.message, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        });
        updateCart.always(function () {
            showCart();
        });
    }

    function deleteCartItem(product_id) {
        var deleteCart = $.ajax({
            type: "post",
            url: url_delete_cart_item,
            data: {
                product_id: product_id,
            },
        });
        deleteCart.done(function (resp) {
            resp = jQuery.parseJSON(resp);
            if (resp.result) {
                toastr["success"]("", resp.message, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            } else {
                toastr["error"]("", resp.message, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        });
        deleteCart.always(function () {
            showCart();
            showCartPage();
        });
    }

    showCart();
    showCartPage();

    // Event
    $(document).on("click", ".btn-cart", function () {
        var product_id = $(this).data("id");
        cartAllItem(product_id);
    });

    $(document).on("click", ".btn-remove-cart", function () {
        var product_id = $(this).data("id");
        deleteCartItem(product_id);
    });

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

    if (quillEditor.length) {
        var Font = Quill.import("formats/font");
        Font.whitelist = ["sofia", "slabo", "roboto", "inconsolata", "ubuntu"];
        Quill.register(Font, true);

        var editor = new Quill("#full-container .editor", {
            bounds: "#full-container .editor",
            modules: {
                toolbar: [
                    [
                        {
                            font: [],
                        },
                        {
                            size: [],
                        },
                    ],
                    ["bold", "italic", "underline", "strike"],
                    [
                        {
                            color: [],
                        },
                        {
                            background: [],
                        },
                    ],
                    [
                        {
                            script: "super",
                        },
                        {
                            script: "sub",
                        },
                    ],
                    [
                        {
                            header: "1",
                        },
                        {
                            header: "2",
                        },
                        "blockquote",
                        "code-block",
                    ],
                    [
                        {
                            list: "ordered",
                        },
                        {
                            list: "bullet",
                        },
                        {
                            indent: "-1",
                        },
                        {
                            indent: "+1",
                        },
                    ],
                    [
                        "direction",
                        {
                            align: [],
                        },
                    ],
                    ["link", "image", "video"],
                    ["clean"],
                ],
            },
            theme: "snow",
        });

        $(document).on("submit", ".form-editor", function (e) {
            e.preventDefault();

            var descriptionError = $("#description-error"),
                description = document.querySelector("input[name=description]");

            description.value = editor.root.innerHTML;
            if (description.value === "<p><br></p>") {
                descriptionError.addClass("d-block");
                descriptionError.text("Nội dung chi tiết không được bỏ trống.");
            } else {
                e.currentTarget.submit();
            }
        });
    }

    if (numeralMask.length) {
        new Cleave(numeralMask, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand",
        });
    }

    if (inputImagesStore.length) {
        inputImagesStore.imageUploader({
            maxFiles: 12,
            maxSize: 10 * 1024 * 1024,
            extensions: [".jpg", ".jpeg", ".png", ".gif"],
            label: "Kéo thả hoặc chọn hình vào đây",
        });
    }

    if (rating.length) {
        $(".rating").starRating({
            starSize: 25,
            disableAfterRate: false,
            onHover: function (currentIndex, currentRating, $el) {
                $(".live-rating").text(currentIndex);
                $("#rating").val(currentRating);
            },
            onLeave: function (currentIndex, currentRating, $el) {
                $(".live-rating").text(currentRating);
                $("#rating").val(currentRating);
            },
        });
    }
})(window);
