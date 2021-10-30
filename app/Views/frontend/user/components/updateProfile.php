<?= form_open_multipart(route_to('user.auth.updateProfile'), ['id' => 'update-profile-form']) ?>
<?= form_hidden('checkImg', isset(user()->avatar) ? user()->avatar : '') ?>
<?= view('components/_message') ?>
<div class="d-flex">
    <a href="#" class="me-25">
        <?= img(showUserImage(user()->avatar), false, ['class' => 'rounded me-50', 'id' => 'blog-feature-image', 'alt' => esc(user()->fullname), 'height' => '80', 'width' => '80']) ?>
    </a>
    <div class="mt-75 ms-1 custom-avatar validate-image">
        <label for="blogCustomFile" class="btn btn-sm btn-primary mb-75 me-75">Chọn Ảnh</label>
        <input type="file" id="blogCustomFile" hidden accept="image/*" name="avatar" />
        <button type="button" id="btn-delete-image" class="btn btn-sm btn-outline-secondary mb-75">Xóa Ảnh</button>
        <p>Chỉ chấp nhận tệp JPG, GIF hoặc PNG.</p>
    </div>
</div>

<div class="mt-2">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="mb-1">
                <?= form_label('E-mail', 'email_current', ['class' => 'form-label text-capitalize']) ?>
                <?= form_input('email_current', user()->email, ['class' => 'form-control', 'id' => 'email_current', 'disabled' => 'disabled']) ?>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-1">
                <?= form_label('Họ Và Tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                <?= form_input('fullname', user()->fullname, ['class' => 'form-control', 'id' => 'fullname']) ?>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-1">
                <?= form_label('Số Điện Thoại', 'phone', ['class' => 'form-label text-capitalize']) ?>
                <?= form_input('phone', user()->phone ? user()->phone : '', ['class' => 'form-control', 'id' => 'phone']) ?>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-1">
                <?= form_label('Nghề Nghiệp', 'job', ['class' => 'form-label text-capitalize']) ?>
                <?= form_input('job', user()->job ? user()->job : '', ['class' => 'form-control', 'id' => 'job']) ?>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1">
                <?= form_label('Ngày Sinh', 'birthdate', ['class' => 'form-label text-capitalize']) ?>
                <?= form_input('birthdate', user()->birthdate ? user()->birthdate : '', ['class' => 'form-control flatpickr', 'id' => 'birthdate']) ?>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1">
                <?= form_label('Địa Chỉ', 'address', ['class' => 'form-label text-capitalize']) ?>
                <?= form_textarea('address', user()->address ? user()->address : '', ['class' => 'form-control', 'id' => 'address', 'rows' => 3]) ?>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="mb-1">
                <?= form_label('Giới tính', '', ['class' => 'form-label text-capitalize']) ?>
                <div class="form-check mb-25">
                    <?= form_radio('gender', '1', user()->gender == 1 ? true : false, ['class' => 'form-check-input', 'id' => 'male']) ?>
                    <?= form_label('Nam', 'male', ['class' => 'custom-control-label']) ?>
                </div>
                <div class="form-check">
                    <?= form_radio('gender', '0', user()->gender == 0 ? true : false, ['class' => 'form-check-input', 'id' => 'female']) ?>
                    <?= form_label('Nữ', 'female', ['class' => 'custom-control-label']) ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <?= form_button(['class' => 'btn btn-primary mt-2 me-1 btn-disabled-image', 'type' => 'submit', 'content' => 'Lưu Thay Đổi']) ?>
        </div>
    </div>
</div>
<?= form_close() ?>