<?= $this->extend('layouts/frontend/index') ?>

<?= $this->section('title'); ?>
<?= esc($row->name) ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/swiper.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/jquery.rateyo.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<style>
  .text-description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .app-ecommerce-details img {
    max-width: 100%;
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
<?= script_tag('app-assets/vendors/js/extensions/jquery.rateyo.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
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

    var commentForm = $('#comment-form');

    if (commentForm.length) {
      commentForm.validate({
        rules: {
          body: {
            required: true,
          },
        },
        messages: {
          body: {
            required: "Nội dung bình luận không được bỏ trống.",
          },
        },
      });
    }

    $(commentForm).on('submit', function(event) {
      event.preventDefault();
      var body = $('#body').val();
      var product_id = $('input[name=product_id]').val();
      var comment_id = $('input[name=comment_id]').val();
      var reply_id = $('input[name=reply_id]').val();
      var rating = $('input[name=rating]').val();

      $.ajax({
        url: "<?= route_to('user.comment.postComment') ?>",
        method: "POST",
        async: true,
        cache: false,
        data: {
          body: body,
          product_id: product_id,
          comment_id: comment_id,
          reply_id: reply_id,
          rating: rating
        },
        dataType: "JSON",
        success: function(response) {
          if (!response.error) {
            $(commentForm)[0].reset();
            $('#message').html(response.message);
            $('input[name=comment_id]').val();
            $('input[name=reply_id]').val();
            showComments();

            if (feather) {
              feather.replace({
                width: 14,
                height: 14
              });
            }
          } else if (response.error) {
            $('#message').html(response.message);
          }
        },
        complete: function() {
          $('input[name=comment_id]').val(0);
          $('input[name=reply_id]').val(0);
          $('input[name=rating]').val(0);
          $('#reply-body').html('');
        }
      })
    });

    showComments(1);

    function showComments(page = 1) {
      var product_id = $('input[name=product_id]').val();

      $.ajax({
        url: "<?= route_to('user.comment.showComments') ?>",
        method: "POST",
        async: true,
        cache: false,
        data: {
          product_id: product_id,
          page: page
        },
        dataType: "JSON",
        success: function(data) {
          $('#show-comment').html(data.html);

          if (feather) {
            feather.replace({
              width: 14,
              height: 14
            });
          }
        }
      })
    }

    $(document).on('click', '.mode-reply', function() {
      var reply_id = $(this).attr("id");
      var comment_id = $(this).data("commentid");
      var comment_body = $(this).data("body");
      $('input[name=comment_id]').val(comment_id);
      $('input[name=reply_id]').val(reply_id);
      $('textarea[name=body]').focus();
      $('#message').html('');
      $('#reply-body').text('Trả Lời Bình Luận: ' + comment_body);
    });

    $(document).on('click', '.reply', function() {
      var comment_id = $(this).attr("id");
      var comment_body = $(this).data("body");
      $('input[name=comment_id]').val(comment_id);
      $('input[name=reply_id]').val(0);
      $('textarea[name=body]').focus();
      $('#message').html('');
      $('#reply-body').text('Trả Lời Bình Luận: ' + comment_body);
    });

    $(document).on('click', 'ul.pagination li a', function(e) {
      e.preventDefault();
      let page = $(this).data('page');
      showComments(page);
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
            <?php if (count($getSumRatingComment) !== 0) : ?>
              <?= starRating($sum / count($getSumRatingComment)) ?>
            <?php else : ?>
              <?= starRating(0) ?>
            <?php endif; ?>
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
  </div>
</section>

<section>
  <div class="row">
    <div class="col-12 mt-1" id="blogComment">
      <h6 class="section-label mt-25">Bình luận về bài đăng</h6>
      <div class="card">
        <div class="card-body" id="show-comment"></div>
      </div>
    </div>
    <div class="col-12 mt-1">
      <h6 class="section-label mt-25">Để lại bình luận</h6>
      <?php if (logged_in()) : ?>
        <div class="card">
          <div class="card-body">
            <?= form_open('', ['id' => 'comment-form', 'class' => 'form']) ?>
            <?= form_hidden('product_id', $row->id) ?>
            <?= form_hidden('comment_id', 0) ?>
            <?= form_hidden('reply_id', 0) ?>

            <div class="mb-1">
              <span id="message"></span>
              <span id="reply-body" class="text-primary"></span>
            </div>

            <div class="row">
              <div class="col-sm-6 col-12">
                <div class="mb-2">
                  <?= form_label('Họ và tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                  <?= form_input('fullname', user()->fullname, ['class' => 'form-control text-capitalize', 'id' => 'fullname', 'disabled' => 'disabled']) ?>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="mb-2">
                  <?= form_label('E-mail', 'email', ['class' => 'form-label text-capitalize']) ?>
                  <?= form_input('email', user()->email, ['class' => 'form-control', 'id' => 'email', 'disabled' => 'disabled']) ?>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="mb-2">
                  <?= form_label('Đánh giá', '', ['class' => 'form-label text-capitalize']) ?>
                  <span class="rating"></span>
                  <span class="live-rating badge bg-primary"></span>
                  <input type="hidden" name="rating" id="rating">
                </div>
              </div>
              <div class="col-12">
                <?= form_label('Nội dung', 'body', ['class' => 'form-label text-capitalize']) ?>
                <?= form_textarea('body', '', ['class' => 'form-control', 'rows' => 4, 'id' => 'body']) ?>
              </div>
              <div class="col-12 mt-2">
                <?= form_button(['class' => 'btn btn-primary', 'type' => 'submit', 'content' => 'Đăng Bình Luận']) ?>
              </div>
            </div>
            <?= form_close() ?>
          </div>
        </div>
      <?php else : ?>
        <?= form_open('', ['id' => 'comment-form', 'class' => 'form']) ?>
        <?= form_hidden('product_id', $row->id) ?>
        <div class="alert alert-primary text-center" role="alert">
          <div class="alert-body">
            <i data-feather="info" class="me-50"></i>
            <span class="text-capitalize">Bạn cần đăng nhập để có thể đăng bình luận cá nhân.</span>
          </div>
        </div>
        <?= form_close() ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if (count($getProductRelated)) : ?>
  <div class="card-body">
    <div class="divider my-3">
      <div class="divider-text">
        <h3 class="text-uppercase font-medium-5">Sản phẩm liên quan</h3>
      </div>
    </div>

    <?= view('components/_product', ['getProduct' => $getProductRelated]) ?>
  </div>
<?php endif; ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->