<?php if (session()->has('message')) : ?>
    <div class="alert alert-success">
        <h4 class="alert-heading">Thành Công!</h4>
        <div class="alert-body">
            <?= session('message') ?>
        </div>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Thất Bại!</h4>
        <div class="alert-body">
            <?= session('error') ?>
        </div>
    </div>
<?php endif ?>