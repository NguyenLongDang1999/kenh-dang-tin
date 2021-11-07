<?= form_open(route_to('user.auth.updateEmail'), ['id' => 'update-email-form']); ?>
<?= view('components/_message') ?>
<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <?= form_label('Nhập E-mail mới', 'email', ['class' => 'form-label']) ?>
            <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email']) ?>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <?= form_label('Mật Khẩu', 'password', ['class' => 'form-label']) ?>

            <div class="input-group input-group-merge form-password-toggle">
                <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'id' => 'password']) ?>
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
        </div>
    </div>

    <div class="col-12">
        <?= form_button(['class' => 'btn btn-primary mt-2 me-1 btn-disabled-image', 'type' => 'submit', 'content' => 'Lưu Thay Đổi']) ?>
    </div>
</div>
<?= form_close() ?>