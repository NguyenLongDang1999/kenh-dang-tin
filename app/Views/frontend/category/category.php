<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
<?= esc($row->name) ?> tại <?= base_url() ?>
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<style>
  .text-description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .ecommerce-application .grid-view {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr !important;
    -webkit-column-gap: 1rem !important;
    -moz-column-gap: 1rem !important;
    column-gap: 1rem !important;
  }

  @media (max-width: 1299.98px) {
    .ecommerce-application .grid-view {
      grid-template-columns: 1fr 1fr 1fr !important;
    }
  }

  @media (max-width: 767.98px) {
    .ecommerce-application .grid-view {
      grid-template-columns: 1fr 1fr !important;
    }
  }
</style>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.script.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/app-ecommerce.min.js') ?>
<script>
  $(function() {
    $('.lazy').lazy();
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
<div class="text-center my-3">
  <div class="divider">
    <div class="divider-text">
      <h1 class="text-uppercase font-medium-5"><?= esc($row->name) ?></h1>
    </div>
  </div>
  <p class="font-medium-1"><?= esc($row->description) ?></p>
</div>

<section id="ecommerce-category">
  <?= view('components/_category', ['getCategory' => $getCategoryList, 'category' => $is_ecommerce_page]) ?>
</section>

<section id="ecommerce-header">
  <div class="row">
    <div class="col-sm-12">
      <div class="ecommerce-header-items">
        <div class="result-toggler">
          <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
          </button>
          <div class="search-results text-capitalize">Hiển thị <?= esc($countProduct) ?> sản phẩm</div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="body-content-overlay"></div>

<?php if (count($getProductShowByCat)) : ?>
  <?= view('components/_product', ['getProduct' => $getProductShowByCat]) ?>

  <section id="ecommerce-pagination">
    <div class="row">
      <div class="col-sm-12">
        <?= $pager->links() ?>
      </div>
    </div>
  </section>
<?php endif; ?>
</div>
</div>
<?= view('components/_filter') ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->