<script>
    var updateProfileForm = $('#update-profile-form'),
        updateEmailForm = $('#update-email-form'),
        updatePasswordForm = $('#update-password-form');

    jQuery.validator.addMethod('valid_phone', function(value) {
        var regex =
            /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
        return value.trim().match(regex);
    });

    if (updateProfileForm.length) {
        updateProfileForm.validate({
            rules: {
                fullname: {
                    required: true,
                    maxlength: 50,
                },
                phone: {
                    required: true,
                    valid_phone: true
                },
                job: {
                    maxlength: 50,
                },
                address: {
                    maxlength: 255,
                },
            },
            messages: {
                fullname: {
                    required: "Họ và tên không được bỏ trống.",
                    maxlength: "Họ và tên không được vượt quá 50 ký tự.",
                },
                phone: {
                    required: "Số điện thoại không được bỏ trống.",
                    valid_phone: "Số điện thoại không hợp lệ.",
                },
                job: {
                    maxlength: "Nghề nghiệp không được vượt quá 50 ký tự.",
                },
                address: {
                    maxlength: "Địa chỉ không được vượt quá 255 ký tự.",
                },
            },
        });
    }

    if (updatePasswordForm.length) {
        updatePasswordForm.validate({
            rules: {
                password: {
                    required: true,
                    maxlength: 15,
                    minlength: 8,
                },
                new_password: {
                    required: true,
                    maxlength: 15,
                    minlength: 8,
                },
                new_password_confirm: {
                    required: true,
                    maxlength: 15,
                    minlength: 8,
                    equalTo: "#new_password"
                },
            },
            messages: {
                password: {
                    required: "Password không được bỏ trống.",
                    maxlength: "Password không được vượt quá 15 ký tự.",
                    minlength: "Password phải có tối thiểu 8 ký tự.",
                },
                new_password: {
                    required: "Password mới không được bỏ trống.",
                    maxlength: "Password không được vượt quá 15 ký tự.",
                    minlength: "Password phải có tối thiểu 8 ký tự.",
                },
                new_password_confirm: {
                    required: "Nhập lại password mới không được bỏ trống.",
                    maxlength: "Password không được vượt quá 15 ký tự.",
                    minlength: "Password phải có tối thiểu 8 ký tự.",
                    equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại."
                },
            },
        });
    }

    if (updateEmailForm.length) {
        updateEmailForm.validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 255,
                    remote: {
                        url: "<?= route_to('user.auth.checkExistsEmail'); ?>",
                        type: 'post',
                        dataType: 'json',
                        async: true,
                        cache: false,
                        dataFilter: function(data) {
                            let obj = eval('(' + data + ')');
                            return obj.valid;
                        },
                    }
                },
                password_current: {
                    required: true,
                    maxlength: 15,
                    minlength: 8,
                },
            },
            messages: {
                email: {
                    required: "Email không được bỏ trống.",
                    maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                    email: "Email không đúng định dạng.",
                    remote: "Email này đã tồn tại. Vui lòng nhập email khác."
                },
                password_current: {
                    required: "Password không được bỏ trống.",
                    maxlength: "Password không được vượt quá 15 ký tự.",
                    minlength: "Password phải có tối thiểu 8 ký tự.",
                }
            },
        });
    }

    $(document).on("click", "#btn-delete-image", function() {
        var url_img = $("#blog-feature-image").attr('src');
        var avatar_defaut = "<?= PATH_AVATAR_DEFAULT ?>";

        $.ajax({
            url: '<?= route_to('user.auth.deleteImageUser') ?>',
            type: "post",
            data: {
                url_img: url_img,
            },
        }).done(function(data) {
            data = jQuery.parseJSON(data);

            if (data.result) {
                $('#avatar-users').attr('src', avatar_defaut);
                $('#user-image-profile').attr('src', avatar_defaut);
                $("#blog-feature-image").attr('src', avatar_defaut);
            }
        });
    });

    $('#tabMenu a').click(function(e) {
        e.preventDefault();
        var id = $(this).attr("href");
        localStorage.setItem('activeTab', id);
    });
    var tabShow = document.querySelector('#tabMenu a[href="' + localStorage.getItem('activeTab') + '"]');
    var tabActive = new bootstrap.Tab(tabShow);
    tabActive.show();
</script>