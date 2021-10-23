<div class="sidebar-detached sidebar-left">
  <div class="sidebar">
    <div class="sidebar-shop">
      <div class="row">
        <div class="col-sm-12">
          <h6 class="filter-heading d-none d-lg-block text-capitalize">Lọc sản phẩm</h6>
        </div>
      </div>
      <div class="card">
        <?= form_open('', ['method' => 'GET', 'id' => 'filter-category']) ?>
        <div class="card-body">
          <div class="multi-range-price">
            <h6 class="filter-title mt-0">Giá Cả</h6>
            <ul class="list-unstyled price-range" id="price-range">
              <li>
                <div class="form-check">
                  <?= form_radio('price_range', '', true, ['class' => 'form-check-input', 'id' => 'priceAll']) ?>
                  <?= form_label('ALL', 'priceAll', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('price_range', '1', (isset($input['price_range']) && $input['price_range'] == 1) ? true : false, ['class' => 'form-check-input', 'id' => 'priceRange1']) ?>
                  <?= form_label('<= 1 Triệu', 'priceRange1', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('price_range', '2', (isset($input['price_range']) && $input['price_range'] == 2) ? true : false, ['class' => 'form-check-input', 'id' => 'priceRange2']) ?>
                  <?= form_label('1 - 100 Triệu', 'priceRange2', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('price_range', '3', (isset($input['price_range']) && $input['price_range'] == 3) ? true : false, ['class' => 'form-check-input', 'id' => 'priceRange3']) ?>
                  <?= form_label('100 Triệu - 1 Tỷ', 'priceRange3', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('price_range', '4', (isset($input['price_range']) && $input['price_range'] == 4) ? true : false, ['class' => 'form-check-input', 'id' => 'priceRange4']) ?>
                  <?= form_label('>= 1 Tỷ', 'priceRange4', ['class' => 'form-check-label']) ?>
                </div>
              </li>
            </ul>
          </div>

          <div>
            <h6 class="filter-title">Sắp Xếp</h6>
            <ul class="list-unstyled brand-list">
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '0', true, ['class' => 'form-check-input', 'id' => 'sort-filter-0']) ?>
                  <?= form_label('Ngày Đăng Mới Nhất (Mặc Định)', 'sort-filter-0', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '1', (isset($input['sort_filter']) && $input['sort_filter'] == 1) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-1']) ?>
                  <?= form_label('Ngày Đăng Cũ Nhất', 'sort-filter-1', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '2', (isset($input['sort_filter']) && $input['sort_filter'] == 2) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-2']) ?>
                  <?= form_label('Lượt Xem (Thấp -> Cao)', 'sort-filter-2', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '3', (isset($input['sort_filter']) && $input['sort_filter'] == 3) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-3']) ?>
                  <?= form_label('Lượt Xem (Cao -> Thấp)', 'sort-filter-3', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '4', (isset($input['sort_filter']) && $input['sort_filter'] == 4) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-4']) ?>
                  <?= form_label('Giá Cả (Thấp -> Cao)', 'sort-filter-4', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '5', (isset($input['sort_filter']) && $input['sort_filter'] == 5) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-5']) ?>
                  <?= form_label('Giá Cả (Cao -> Thấp)', 'sort-filter-5', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '6', (isset($input['sort_filter']) && $input['sort_filter'] == 6) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-6']) ?>
                  <?= form_label('Tên (A - Z)', 'sort-filter-6', ['class' => 'form-check-label']) ?>
                </div>
              </li>
              <li>
                <div class="form-check">
                  <?= form_radio('sort_filter', '7', (isset($input['sort_filter']) && $input['sort_filter'] == 7) ? true : false, ['class' => 'form-check-input', 'id' => 'sort-filter-7']) ?>
                  <?= form_label('Tên (Z - A)', 'sort-filter-7', ['class' => 'form-check-label']) ?>
                </div>
              </li>
            </ul>
          </div>

          <div>
            <h6 class="filter-title">Số Lượng Sản Phẩm Trong Trang</h6>
            <ul class="list-unstyled brand-list">
              <li>
                <div class="form-check">
                  <?= form_radio('paginate', '20', true, ['class' => 'form-check-input', 'id' => 'paginate-20']) ?>
                  <?= form_label('20 (Mặc Định)', 'paginate-0', ['class' => 'form-check-label']) ?>
                </div>
              </li>

              <li>
                <div class="form-check">
                  <?= form_radio('paginate', '40', (isset($input['paginate']) && $input['paginate'] == 40) ? true : false, ['class' => 'form-check-input', 'id' => 'paginate-40']) ?>
                  <?= form_label('40', 'paginate-40', ['class' => 'form-check-label']) ?>
                </div>
              </li>

              <li>
                <div class="form-check">
                  <?= form_radio('paginate', '60', (isset($input['paginate']) && $input['paginate'] == 60) ? true : false, ['class' => 'form-check-input', 'id' => 'paginate-60']) ?>
                  <?= form_label('60', 'paginate-60', ['class' => 'form-check-label']) ?>
                </div>
              </li>

              <li>
                <div class="form-check">
                  <?= form_radio('paginate', '80', (isset($input['paginate']) && $input['paginate'] == 80) ? true : false, ['class' => 'form-check-input', 'id' => 'paginate-80']) ?>
                  <?= form_label('80', 'paginate-80', ['class' => 'form-check-label']) ?>
                </div>
              </li>

              <li>
                <div class="form-check">
                  <?= form_radio('paginate', '100', (isset($input['paginate']) && $input['paginate'] == 100) ? true : false, ['class' => 'form-check-input', 'id' => 'paginate-100']) ?>
                  <?= form_label('100', 'paginate-100', ['class' => 'form-check-label']) ?>
                </div>
              </li>
            </ul>
          </div>

          <?= form_button(['class' => 'btn w-100 btn-primary', 'type' => 'submit', 'content' => 'Lọc Bài Đăng']) ?>
        </div>
        <?= form_close() ?>
      </div>
    </div>

  </div>
</div>