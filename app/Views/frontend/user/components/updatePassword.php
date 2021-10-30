<?= form_open(route_to('user.auth.updatePassword'), ['id' => 'update-password-form']); ?>
<?= view('components/_message') ?>
<div class="row">
    <div class="col-12 col-sm-6">
        <div class="mb-1">
            <?= form_label('Mật Khẩu', 'password', ['class' => 'form-label']) ?>

            <div class="input-group input-group-merge form-password-toggle">
                <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'id' => 'password']) ?>
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6">
        <div class="mb-1">
            <?= form_label('Mật Khẩu Mới', 'new_password', ['class' => 'form-label']) ?>

            <div class="input-group input-group-merge form-password-toggle">
                <?= form_password('new_password', '', ['class' => 'form-control form-control-merge', 'id' => 'new_password']) ?>
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="mb-1">
            <?= form_label('Nhập Lại Mật Khẩu Mới', 'new_password_confirm', ['class' => 'form-label']) ?>

            <div class="input-group input-group-merge form-password-toggle">
                <?= form_password('new_password_confirm', '', ['class' => 'form-control form-control-merge', 'id' => 'new_password_confirm']) ?>
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?= form_button(['class' => 'btn btn-primary me-1 mt-1', 'type' => 'submit', 'content' => 'Lưu Thay Đổi']) ?>
        <?= form_button(['class' => 'btn btn-outline-secondary mt-1', 'type' => 'reset', 'content' => 'Reset']) ?>
    </div>
</div>
<?= form_close() ?>