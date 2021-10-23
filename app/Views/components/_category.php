<div class="row">
  <?php foreach ($getCategory as $item) : ?>
    <div class="<?= isset($category) && $category ? 'col-xl-3' : 'col-xl-2' ?> col-md-4 col-6">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar bg-light-info p-50 mb-1">
            <div class="avatar-content">
              <a href="<?= route_to('user.category.category', esc($item->slug), esc($item->id)) ?>">
                <?= img(showCategoryImage($item->image), false, ['width' => 50, 'height' => 50, 'alt' => esc($item->name)]) ?>
              </a>
            </div>
          </div>
          <h4 class="text-capitalize">
            <a href="<?= route_to('user.category.category', esc($item->slug), esc($item->id)) ?>" class="fw-bolder text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= esc($item->name) ?>">
              <?= esc($item->name) ?>
            </a>
          </h4>
          <p class="card-text text-description"><?= esc($item->description) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>