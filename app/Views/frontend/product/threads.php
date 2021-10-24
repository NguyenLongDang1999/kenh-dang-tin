<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
<?= esc($row->name) ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/swiper.min.css') ?>
<style>
  .text-description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .app-ecommerce-details img {
    width: 100%;
    height: auto;
  }

  .ecommerce-application .grid-view {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr !important;
    -webkit-column-gap: 1rem !important;
    -moz-column-gap: 1rem !important;
    column-gap: 1rem !important;
  }

  @media (max-width: 991.98px) {
    .ecommerce-application .grid-view {
      grid-template-columns: 1fr 1fr 1fr !important;
    }
  }

  @media (max-width: 575.98px) {
    .ecommerce-application .grid-view {
      grid-template-columns: 1fr 1fr !important;
    }
  }
</style>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce-details.min.css') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/swiper.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.script.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
  $(function() {
    'use strict';

    $('.lazy').lazy();
    var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 6,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true
    });
    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      thumbs: {
        swiper: galleryThumbs
      }
    });
  })
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
                <a href="<?= route_to('user.home.index') ?>" class="text-capitalize">
                  Trang chủ
                </a>
              </li>
              <?= $breadcrumbs ?>
              <li class="breadcrumb-item text-capitalize active" aria-current="page"><?= esc($row->name) ?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="app-ecommerce-details">
  <div class="card">
    <!-- Product Details starts -->
    <div class="card-body">
      <div class="row my-2">
        <div class="col-12 col-md-5 mb-2 mb-md-0">
          <div class="swiper-gallery swiper-container gallery-top">
            <div class="swiper-wrapper">
              <div class="swiper-slide text-center">
                <a href="<?= showProductImage(esc($row->image), true) ?>" data-fancybox="gallery">
                  <?= img(showProductImage(esc($row->image), false), false, ['class' => 'card-img w-50', 'alt' => esc($row->name)]) ?>
                </a>
              </div>
              <?php if (!is_null($gallery)) : ?>
                <?php foreach ($gallery as $img) : ?>
                  <div class="swiper-slide text-center">
                    <a href="<?= showProductMultiImage(esc($img), true) ?>" data-fancybox="gallery">
                      <?= img(showProductMultiImage(esc($img), true), false, ['class' => 'card-img w-50', 'alt' => esc($row->name)]) ?>
                    </a>
                  </div>
                <?php endforeach ?>
              <?php endif; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="swiper-container gallery-thumbs">
            <div class="swiper-wrapper mt-25">
              <div class="swiper-slide">
                <?= img(showProductImage(esc($row->image)), false, ['class' => 'card-img card-img-top', 'alt' => esc($row->name)]) ?>
              </div>
              <?php if (!is_null($gallery)) : ?>
                <?php foreach ($gallery as $img) : ?>
                  <div class="swiper-slide">
                    <?= img(showProductMultiImage(esc($img)), false, ['class' => 'card-img card-img-top', 'alt' => esc($row->name)]) ?>
                  </div>
                <?php endforeach ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-7">
          <h1 class="text-capitalize card-title">
            <?php if ($row->featured == FEATURED_ACTIVE) : ?>
              <span class="badge bg-primary p-75 me-1">
                <i data-feather="zap"></i>
                HOT
              </span>
            <?php endif; ?>
            <?= esc($row->name) ?>
          </h1>
          <ul class="unstyled-list list-inline">
            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
          </ul>
          <p class="card-text">Available - <span class="text-success">In stock</span></p>
          <ul class="list-unstyled">
            <li><i data-feather="dollar-sign"></i> <?= esc(number_to_amount($row->price - ($row->price * ($row->sale / 100)), 2, 'vi_VN')) ?> (<span class="text-decoration-line-through text-muted"><?= $row->price !== 0 ? esc(number_to_amount($row->price, 2, 'vi_VN')) : 'Thương Lượng' ?></span>) </li>
            <li><i data-feather="code"></i> <?= esc($row->sku) ?></li>
            <li><i data-feather="eye"></i> <?= esc($row->view) ?></li>
          </ul>

          <p class="card-text">
            <?= esc($row->small_description) ?>
          </p>
          <hr />
          <div class="d-flex flex-column flex-sm-row pt-1">
            <a href="#" class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0">
              <i data-feather="shopping-cart" class="me-50"></i>
              <span class="add-to-cart">Thêm Vào Giỏ Hàng</span>
            </a>
            <a href="#" class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0">
              <i data-feather="heart" class="me-50"></i>
              <span>Yêu Thích</span>
            </a>
            <div class="btn-group dropdown-icon-wrapper btn-share">
              <button type="button" class="btn btn-icon hide-arrow btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="share-2" class="me-50"></i>
                Chia Sẻ
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <i data-feather="facebook"></i>
                </a>
                <a href="#" class="dropdown-item">
                  <i data-feather="twitter"></i>
                </a>
                <a href="#" class="dropdown-item">
                  <i data-feather="youtube"></i>
                </a>
                <a href="#" class="dropdown-item">
                  <i data-feather="instagram"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Product Details ends -->

    <div class="card-body">
      <div class="divider my-3">
        <div class="divider-text">
          <h3 class="text-uppercase font-medium-5">Mô tả chi tiết sản phẩm</h3>
        </div>
      </div>
      <p class="card-text my-2">
        <?= $row->large_description ?>
      </p>
    </div>

    <?php if (count($getProductRelated)) : ?>
      <!-- Related Products starts -->
      <div class="card-body">
        <div class="divider my-3">
          <div class="divider-text">
            <h3 class="text-uppercase font-medium-5">Sản phẩm liên quan</h3>
          </div>
        </div>

        <?= view('components/_product', ['getProduct' => $getProductRelated]) ?>
      </div>
      <!-- Related Products ends -->
    <?php endif; ?>
  </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->