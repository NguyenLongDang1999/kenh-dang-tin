<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Product;
use App\Models\Category;

class ProductController extends BaseController
{
    protected $slug;
    protected $product;
    protected $category;

    public function __construct()
    {
        $this->slug = new Slug();
        $this->product = new Product();
        $this->category = new Category();
    }

    public function index()
    {
        $category = $this->category->getTreeCategory();
        unset($category[0]);
        $data['option'] = $category;
        return view('backend/product/index', $data);
    }

    public function getList()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->product->getList($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {
                $price = ($row->price != 0) ? esc(number_to_amount($row->price, 2, 'vi_VN')) : 'Thương Lượng';
                $money = esc(number_to_amount($row->price - ($row->price * ($row->sale / 100)), 2, 'vi_VN'));

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'image'             => img(showProductImage($row->image), false, ['alt' => esc($row->name), 'class' => 'round', 'width' => '120', 'height' => '120']),
                    'infoProduct'       => $this->infoProduct($row->name, $row->view, $row->catName),
                    'infoPrice'         => $this->infoPrice($price, $row->sale, $money),
                    'status'            => esc($row->status),
                    'featured'          => esc($row->featured),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'title'             => esc($row->name),
                    'editPages'         => route_to('admin.product.edit', $row->id)
                ];
            }
        }

        return json_encode($data);
    }

    public function recycle()
    {
        return view('backend/product/recycle');
    }

    public function getListRecycle()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->product->getListRecycle($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {
                $price = ($row->price != 0) ? esc(number_to_amount($row->price, 2, 'vi_VN')) : 'Thương Lượng';
                $money = esc(number_to_amount($row->price - ($row->price * ($row->sale / 100)), 2, 'vi_VN'));

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'image'             => img(showProductImage($row->image), false, ['alt' => esc($row->name), 'class' => 'round', 'width' => '120', 'height' => '120']),
                    'infoProduct'       => $this->infoProduct($row->name, $row->view, $row->catName),
                    'infoPrice'         => $this->infoPrice($price, $row->sale, $money),
                    'featured'          => esc($row->featured),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'title'             => esc($row->name),
                ];
            }
        }

        return json_encode($data);
    }

    public function create()
    {
        $category = $this->category->getTreeCategory();
        unset($category[0]);
        $data['option']  = $category;
        return view('backend/product/create_edit', $data);
    }

    public function store()
    {
        $input = $this->request->getPost([
            'name',
            'cat_id',
            'brand_id',
            'sale',
            'quantity',
            'image',
            'image_list',
            'description',
            'meta_title',
            'status',
            'featured',
            'meta_keyword',
            'meta_description'
        ]);

        $input['price'] = str_replace(',', '', $this->request->getPost('price'));

        if (is_null($input['status'])) $input['status'] = STATUS_INACTIVE;
        if (is_null($input['featured'])) $input['featured'] = FEATURED_INACTIVE;

        // Upload Single File
        $file = $this->request->getFile('image');
        if ($file) {
            $resize = [
                'resizeX' => '120',
                'resizeY' => '120',
            ];
            $input['image'] = uploadOneFile($file, PATH_PRODUCT_IMAGE, $resize);
        }

        // Upload Multiple Files
        $files = $this->request->getFiles();
        $input['image_list'] = $files ? uploadMultipleFiles($files['images'], PATH_PRODUCT_IMAGE) : null;
        $input['slug'] = $this->slug->str_slug($input['name']);
        $this->product->insert($input);
        return redirect()->route('admin.product.index')->with('success', "Sản phẩm <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
    }

    public function edit($id)
    {
        $category = $this->category->getTreeCategory();
        unset($category[0]);
        $row = $this->product->getDetailProduct($id);
        $data['gallery'] = explode(',', $row->image_list);
        $data['count'] = 1;
        $data['option']  = $category;
        $data['row'] = $row;
        return view('backend/product/create_edit', $data);
    }

    public function update($id)
    {
        $input = $this->request->getPost([
            'name',
            'cat_id',
            'brand_id',
            'sale',
            'quantity',
            'image_list',
            'description',
            'meta_title',
            'status',
            'featured',
            'meta_keyword',
            'meta_description',
            'checkImg'
        ]);

        $row = $this->product->getDetailProduct($id);

        $input['price'] = str_replace(',', '', $this->request->getPost('price'));

        if (is_null($input['status'])) $input['status'] = STATUS_INACTIVE;
        if (is_null($input['featured'])) $input['featured'] = FEATURED_INACTIVE;

        // Upload Single File
        $file = $this->request->getFile('image');
        if ($file) {
            $resize = [
                'resizeX' => '120',
                'resizeY' => '120',
            ];
            $image = uploadOneFile($file, PATH_PRODUCT_IMAGE, $resize, true, $input['checkImg']);

            $input['image'] = !is_null($image) ? $image : $input['checkImg'];
        }

        // Upload Multiple Files
        $files = $this->request->getFiles();
        $image_list = $files ? uploadMultipleFiles($files['photos'], PATH_PRODUCT_IMAGE, true, $row->image_list) : null;
        $image_list_unique = explode(',', $image_list);
        $unset_dupplicate = array_unique($image_list_unique);
        $image_list_gallery = implode(',', $unset_dupplicate);
        $input['image_list'] = $image_list_gallery;

        $input['slug'] = $this->slug->str_slug($input['name']);
        $this->product->update($id, $input);
        return redirect()->route('admin.product.index')->with('success', "Sản phẩm <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
    }

    public function deleteProductImage()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('product_id');
            $row = $this->product->getDetailProduct($id);
            $url_img = $this->request->getPost('url_img');
            $convert = explode('/', $url_img);
            $getEndConvert = end($convert);
            $gallery = explode(',', $row->image_list);
            if (($key = array_search($getEndConvert, $gallery)) !== false) {
                unset($gallery[$key]);
            }
            $result['image_list'] = implode(',', $gallery);
            if ($this->product->update($id, $result)) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Khôi phục thành công tất cả dữ liệu được chọn.</span>';
                deleteImage(PATH_PRODUCT_SMALL_IMAGE, $getEndConvert);
                deleteImage(PATH_PRODUCT_MEDIUM_IMAGE, $getEndConvert);
            }
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">Có lỗi xảy ra trong quá trình xóa hình ảnh.</span>';
            return json_encode($data);
        }
    }

    public function multiStatus()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">Bạn không thể gửi yêu cầu liên tục. Vui lòng chờ ' . $throttler->getTokentime() . ' giây</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        $status = $this->request->getPost('status');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
            if ($this->product->update($result['chk'], ['status' => $status])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiDestroy()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">Bạn không thể gửi yêu cầu liên tục. Vui lòng chờ ' . $throttler->getTokentime() . ' giây</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->product->delete($result['chk'])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Xóa thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiPurgeDestroy()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">Bạn không thể gửi yêu cầu liên tục. Vui lòng chờ ' . $throttler->getTokentime() . ' giây</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            $multiProduct = $this->product->getMultiProduct($result['chk']);
            deleteImage(PATH_PRODUCT_IMAGE, $multiProduct[0]->image);

            foreach ($multiProduct as $item) {
                $gallery = explode(',', $item->image_list);
                deleteMultipleProductImage(PATH_PRODUCT_SMALL_IMAGE, $gallery);
                deleteMultipleProductImage(PATH_PRODUCT_MEDIUM_IMAGE, $gallery);
            }

            if ($this->product->delete($result['chk'], true)) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiRestore()
    {
        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            $data['result'] = false;
            $data['message'] = '<span class="text-capitalize">Bạn không thể gửi yêu cầu liên tục. Vui lòng chờ ' . $throttler->getTokentime() . ' giây</span>';
            return json_encode($data);
        }

        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->product->update($result['chk'], ['deleted_at' => NULL])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Khôi phục thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    private function infoProduct($productName, $view, $catName)
    {
        $html = '';
        $html .= '<ul class="list-unstyled">';
        $html .= '<li class="pb-25">Tên sản phẩm: <span class="text-bold-500 text-capitalize">' . esc(character_limiter($productName, 30, '...')) . '</span></li>';
        $html .= '<li class="pb-25">Danh Mục: <span class="text-bold-500 text-capitalize">' . esc(character_limiter($catName, 20, '...')) . '</span></li>';
        $html .= '<li class="pb-25">Lượt Xem: <span class="text-bold-500">' . $view . '</span></li>';
        $html .= '</ul>';
        return $html;
    }

    private function infoPrice($price, $sale, $money)
    {
        $html = '';
        $html .= '<ul class="list-unstyled">';
        $html .= '<li class="pb-25">Giá Nhập: <span class="text-bold-500">' . $price . ' VNĐ</span></li>';
        $html .= '<li class="pb-25">Giảm Giá: <span class="text-bold-500">' . $sale . '%</span></li>';
        $html .= '<li class="pb-25">Giá Tiền: <span class="text-bold-500">' . $money . ' VNĐ</span></li>';
        $html .= '</ul>';
        return $html;
    }

    public function checkExists()
    {
        $name = $this->request->getPost('name');
        $slug = $this->slug->str_slug($name);
        $result = $this->product->checkExists($slug);
        $valid = $result > 0 ? false : true;
        return $this->response->setJSON([
            'valid' => $valid,
        ]);
    }
}
