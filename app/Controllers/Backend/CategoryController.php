<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Category;

class CategoryController extends BaseController
{
    protected $slug;
    protected $category;

    public function __construct()
    {
        $this->slug = new Slug();
        $this->category = new Category();
    }

    public function index()
    {
        return view('backend/category/index');
    }

    public function getList()
    {
        $input = $this->request->getGet();
        $input['parent_id'] = 0;
        $data = array();

        $results = $this->category->getList($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'image'             => img(showCategoryImage($row->image), false, ['alt' => esc($row->name), 'class' => 'round', 'width' => '120', 'height' => '120']),
                    'name'              => '<a class="text-capitalize text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . esc($row->name) . '" href="' . route_to('admin.category.edit', $row->id) . '">' . character_limiter(esc($row->name), 15, '...') . '</a>',
                    'parent_id'         => '<a class="text-capitalize text-body badge badge-pill badge-light-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Danh mục con của ' . esc($row->name) . '" href="' . route_to('admin.category.subcategorites', $row->id) . '">' . $this->category->getCountSubcategorites($row->id) . ' Subcategorites</a>',
                    'status'            => esc($row->status),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'title'             => esc($row->name),
                    'editPages'         => route_to('admin.category.edit', $row->id)
                ];
            }
        }

        return json_encode($data);
    }

    public function recycle()
    {
        $data['getListCategoryParent'] = $this->category->getListCategoryParent();
        return view('backend/category/recycle', $data);
    }

    public function getListRecycle()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->category->getListRecycle($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                if ($row->parent_id == 0) {
                    $showName = '-';
                } else {
                    $showName = $this->category->select('name')->find($row->parent_id)->name;
                }

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'image'             => img(showCategoryImage($row->image), false, ['alt' => esc($row->name), 'class' => 'round', 'width' => '120', 'height' => '120']),
                    'name'              => '<span class="text-capitalize">' . character_limiter(esc($row->name), 15, '...') . '</span>',
                    'parent_id'         => '<span class="text-capitalize">' . character_limiter(esc($showName), 15, '...') . '</span>',
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'title'             => esc($row->name)
                ];
            }
        }

        return json_encode($data);
    }

    public function subcategorites($id)
    {
        $data['row'] = $this->category->select('id, name')->find($id);
        return view('backend/category/subcategorites', $data);
    }

    public function getListSubcategory($id)
    {
        $input = $this->request->getGet();
        $input['parent_id'] = $id;
        $data = array();

        $results = $this->category->getList($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'image'             => img(showCategoryImage($row->image), false, ['alt' => esc($row->name), 'class' => 'round', 'width' => '120', 'height' => '120']),
                    'name'              => '<a class="text-capitalize text-body" href="' . route_to('admin.category.subcategorites', $row->id) . '">' . character_limiter(esc($row->name), 15, '...') . '</a>',
                    'parent_id'         => '<a class="text-capitalize text-body badge badge-pill badge-light-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Danh mục con của ' . esc($row->name) . '" href="' . route_to('admin.category.subcategorites', $row->id) . '">' . $this->category->getCountSubcategorites($row->id) . ' Subcategorites</a>',
                    'status'            => esc($row->status),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'title'             => esc($row->name),
                    'editPages'         => route_to('admin.category.edit', $row->id)
                ];
            }
        }

        return json_encode($data);
    }

    public function reorder()
    {
        $parent_id = 0;
        $data['getParentCategory'] = $this->category->getParentCategory($parent_id);
        return view('backend/category/reorder', $data);
    }

    public function reorderSubcategorites($id)
    {
        $data['getParentCategory'] = $this->category->getParentCategory($id);
        return view('backend/category/reorderSubcategorites', $data);
    }

    public function postOrder()
    {
        $result = $this->request->getPost('new_order');
        if (isset($result)) {
            foreach ($result as $key => $item) {
                if ($this->category->update($item['id'], ['sort' => $key + 1])) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">Cập nhật vị trí sắp xêp danh mục thành công.</span>';
                }
            }

            return json_encode($data);
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function create()
    {
        $data['option'] = $this->category->getTreeCategory();
        return view('backend/category/create_edit', $data);
    }

    public function store()
    {
        $input = $this->request->getPost([
            'name',
            'description',
            'parent_id',
            'status',
            'meta_keyword',
            'meta_description'
        ]);

        if (is_null($input['status'])) {
            $input['status'] = STATUS_INACTIVE;
        }

        $sort = $this->category->select('id')->countAllResults();
        $input['sort'] = $sort + 1;

        $file = $this->request->getFile('image');
        if ($file) {
            $resize = [
                'resizeX' => '120',
                'resizeY' => '120',
            ];
            $input['image'] = uploadOneFile($file, PATH_CATEGORY_IMAGE, $resize);
        }

        $input['slug'] = $this->slug->str_slug($input['name']);
        $this->category->insert($input);
        return redirect()->route('admin.category.index')->with('success', "Danh mục <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
    }

    public function edit($id)
    {
        $data['row'] = $this->category->getDetailCategory($id);
        $data['option'] = $this->category->getTreeCategory();
        return view('backend/category/create_edit', $data);
    }

    public function update($id)
    {
        $input = $this->request->getPost([
            'name',
            'description',
            'parent_id',
            'meta_keyword',
            'meta_description',
            'checkImg'
        ]);

        $file = $this->request->getFile('image');
        if ($file) {
            $resize = [
                'resizeX' => '120',
                'resizeY' => '120',
            ];
            $input['image'] =  uploadOneFile($file, PATH_CATEGORY_IMAGE, $resize, true, $input['checkImg']);
        }

        $input['slug'] = $this->slug->str_slug($input['name']);
        $this->category->update($id, $input);
        return redirect()->route('admin.category.index')->with('success', "Danh mục <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được cập nhật.");
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
            if ($this->category->checkParentCategory($result['chk']) === 0) {
                if ($this->category->update($result['chk'], ['status' => $status])) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
                    return json_encode($data);
                }
            } else {
                $data['result'] = false;
                $data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
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
            if ($this->category->checkParentCategory($result['chk']) === 0) {
                if ($this->category->delete($result['chk'])) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">Xóa thành công tất cả dữ liệu được chọn.</span>';
                    return json_encode($data);
                }
            } else {
                $data['result'] = false;
                $data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
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
            if ($this->category->checkParentCategory($result['chk'], true) === 0) {
                $multiCategory = $this->category->getMultiImageCategory($result['chk']);
                deleteMultipleImage(PATH_CATEGORY_IMAGE, $multiCategory);

                if ($this->category->delete($result['chk'], true)) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
                    return json_encode($data);
                }
            } else {
                $data['result'] = false;
                $data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
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
            if ($this->category->checkParentCategory($result['chk'], true) === 0) {
                if ($this->category->update($result['chk'], ['deleted_at' => NULL])) {
                    $data['result'] = true;
                    $data['message'] = '<span class="text-capitalize">Khôi phục thành công tất cả dữ liệu được chọn.</span>';
                    return json_encode($data);
                }
            } else {
                $data['result'] = false;
                $data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function checkExists()
    {
        $name = $this->request->getPost('name');
        $slug = $this->slug->str_slug($name);
        $result = $this->category->checkExists($slug);
        $valid = $result > 0 ? false : true;
        return $this->response->setJSON([
            'valid' => $valid,
        ]);
    }
}
